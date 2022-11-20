<?php
declare(strict_types=1);

namespace app\middleware\system;

use app\constant\Auth;
use app\constant\Code;
use app\constant\Token;
use app\exception\RickException;
use app\system\model\SystemAccount;
use app\system\model\SystemAccountRole;
use app\system\model\SystemRoleRouters;
use Firebase\JWT\Key;
use Webman\MiddlewareInterface;
use Firebase\JWT\JWT;
use Webman\Http\Response;
use Webman\Http\Request;

class VerifyMiddleware implements MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
        $except = [
            ['app\\system\\controller\\AccountController', 'getAccount'],
            ['app\\system\\controller\\AccountController', 'editPass'],
            ['app\\system\\controller\\AccountAuthController', 'login'],
            ['app\\system\\controller\\AccountAuthController', 'captcha']
        ];
        // 当前请求的路由对象实例
        $rule = $request->route;
        if (!in_array($rule->getCallback(), $except)) {
            // 验证Token并获取用户ID
            $token = $request->header(Token::SYSTEM_TOKEN_HEADER);
            if (empty($token)) {
                throw new RickException('请先登录再进行操作', Code::LOGIN_ERROR);
            }
            $userId = JWT::decode($token, new Key(Auth::SYSTEM_JWT_KEY, 'HS256'));
            // 获取用户信息
            $user = SystemAccount::where('id', $userId->data->userId)->find();
            if (!$user) {
                throw new RickException('账户数据发生变化，无法查询到当前用户', Code::LOGIN_ERROR);
            }
            if ($user->status == 0) {
                throw new RickException('账户已被封禁,已被强制下线', Code::LOGIN_ERROR);
            }
            // 获取用户的角色组
            $roles = SystemAccountRole::getRoleList($user->id);
            // 获取角色组的菜单权限列表
            $authorities = SystemRoleRouters::getRouterListNotMenu($roles[0]['roleId']);
            // 定义一个bool类型变量
            $auth = false;
            // 循环菜单权限列表
            foreach ($authorities as $v) {
                // 找到权限标识与请求路由相同的菜单权限 并且 这个权限的类型必须是按钮
                if ($v['authority'] == $rule->getPath() && $v['type'] != 0) {
                    // 为真
                    $auth = true;
                    break;
                }
            }
            // 如果为假则证明没有权限访问
            if (!$auth) {
                throw new RickException('没有权限', Code::NOT_AUTH);
            }
        }
        return $handler($request);
    }
}