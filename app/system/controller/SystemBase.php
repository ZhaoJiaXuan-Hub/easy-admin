<?php

namespace app\system\controller;

use app\constant\Code;
use app\constant\Gravatar;
use app\constant\Token;
use app\constant\Auth;
use app\exception\RickException;
use app\system\model\SystemAccount;
use app\system\model\SystemAccountRole;
use app\system\model\SystemRoleRouters;
use app\system\model\SystemRouter;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use support\Request;
use think\facade\Db;
use Webman\Config;

class SystemBase
{
    static public array $config = [];

    public function __construct()
    {
        $config = Db::name('configs')->column('v', 'k');
        static::$config = $config;
    }

    /**
     * 获取登录用户ID
     * @return int
     * @throws RickException
     */
    public function getUserId(): int
    {
        $token = request()->header(Token::SYSTEM_TOKEN_HEADER);
        if(empty($token)){
            throw new RickException('请先登录再进行操作', Code::LOGIN_ERROR);
        }

        $user = JWT::decode($token, new Key(Auth::SYSTEM_JWT_KEY,'HS256'));

        return $user->data->userId;
    }

    /**
     * 获取用户信息
     * @param Request $request
     * @return array
     * @throws RickException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserInfo(Request $request): array
    {
        $userId = $this->getUserId($request);

        $user = SystemAccount::where('id', $userId)->find();
        if (!$user) {
            throw new RickException('账户数据发生变化，无法查询到当前用户', Code::LOGIN_ERROR);
        }

        $result = $user->toArray();

        $result['avatar'] = Gravatar::ADDRESS . md5($result['email']);

        $result['roles'] = SystemAccountRole::getRoleList($result['id']);

        $result['authorities'] = SystemRoleRouters::getRouterList($result['roles'][0]['roleId']);


        return $result;
    }

    /**
     * 获取用户权限菜单
     * @param int $roleId
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function listRoleMenus(int $roleId): array
    {
        $menus = SystemRouter::where(1)->select();
        $router = SystemRoleRouters::getRouterListNotMenu($roleId);
        foreach ($menus as $key => $value) {
            foreach ($router as $v) {
                $menus[$key]['checked'] = false;
                if ($value['menuId'] == $v['menuId']) {
                    $menus[$key]['checked'] = true;
                    break;
                }
            }
        }
        return $this->treeMenu($menus->toArray());
    }

    /**
     * 无限级节点菜单
     * @param array $cate
     * @param int $pid
     * @param int $level
     * @return array
     */
    public function treeMenu(array $cate , int $pid = 0 , int $level = 0 ): array
    {
        $arr = [];
        foreach($cate as $k => $v){
            if($v['parentId'] == $pid) {
                $data = [];
                $data['id'] = $v['menuId'];
                $data['title'] = $v['title'];
                $data['pid'] = $pid;
                $data['spread'] = true;
                unset($cate[$k]); //删除该节点，减少递归的消耗
                $data['children'] = $this->treeMenu($cate, $v['menuId'], $level + 1);
                if(empty($data['children'])){
                    if(!empty($v['checked'])){
                        $data['checked'] = $v['checked'];
                    }
                    unset($data['children']);
                }
                $arr[] = $data;
            }
        }
        return $arr;
    }
}