<?php
declare(strict_types=1);

namespace app\service\system\socket;

use app\constant\Code;
use app\constant\Auth;
use app\exception\RickException;
use app\service\System\AccountAuthServiceInterface;
use app\system\model\SystemAccount;
use app\system\model\SystemLoginLog;
use app\utils\DateUtil;
use app\utils\RealUtil;
use app\utils\StringUtil;
use Firebase\JWT\JWT;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\facade\Cache;
use Webman\Captcha\CaptchaBuilder;
use support\Request;

class AccountAuthService implements AccountAuthServiceInterface
{

    /**
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     * @throws RickException
     */
    public function login(Request $request, array $data): string
    {
        if (strtolower($data['code']) !== Cache::get('captcha')) {
            throw new RickException('验证码错误', Code::FAIL);
        }
        //通过Model方法获取用户数据
        $user = SystemAccount::where('username', $data['username'])->find();
        //判断用户是否存在
        if (!$user) {
            throw new RickException('用户名不存在', Code::FAIL);
        }
        //判断密码是否正确
        if ($user->password != StringUtil::generatePassword((string)$data['password'], $user->salting)) {
            throw new RickException('密码不正确', Code::FAIL);
        }
        //判断账户是否暂停使用
        if ($user->status != 1) {
            throw new RickException('当前账户存在风险，无法登录');
        }
        //获取JWT密钥
        $expire = (int)Auth::SYSTEM_JWT_EXPIRE;

        $loginDate = DateUtil::current();

        $loadData = array(
            "exp" => time() + $expire,
            "data" => [
                "userId" => $user->id,
                'loginDate' => $loginDate
            ]
        );

        $jwt = JWT::encode($loadData, Auth::SYSTEM_JWT_KEY, "HS256");

        $user->loginTime = DateUtil::current();

        $logData = [
            "username"  => $user->username,
            "userId"    =>  $user->id
        ];
        // 导入登录记录
        SystemLoginLog::add($logData);
        $user->save();

        return $jwt;
    }

    public function captcha(Request $request): string
    {
        // 初始化验证码类
        $builder = new CaptchaBuilder;
        // 生成验证码
        $builder->build();
        // 将验证码的值存储到session中
        Cache::set('captcha', strtolower($builder->getPhrase()));
        // 获得验证码图片二进制数据
        return $builder->get();
    }
}