<?php
declare(strict_types=1);

namespace app\service\system\socket;

use app\constant\Code;
use app\exception\RickException;
use app\service\System\AccountServiceInterface;
use app\system\model\SystemAccount;
use app\system\model\SystemAccountRole;
use app\utils\StringUtil;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

class AccountService implements AccountServiceInterface
{
    /**
     * @throws DataNotFoundException
     * @throws RickException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    public function editPass(array $data): bool
    {
        //通过Model方法获取用户数据
        $user = SystemAccount::where('id', $data['id'])->find();
        //判断用户数据是否存在
        if (!$user) {
            throw new RickException('用户不存在', Code::FAIL);
        }
        //判断原密码是否正确
        if ($user->password != StringUtil::generatePassword((string)$data['oldPassword'], $user->salting)) {
            throw new RickException('原密码不正确', Code::FAIL);
        }
        //生成一个密码盐
        $salting = StringUtil::generateRandStr();
        //使用密码盐加密密码
        $password = StringUtil::generatePassword((string)$data['password'], $salting);
        //保存密码盐和密码
        $user->salting = $salting;
        $user->password = $password;
        $data = $user->save();
        //判断是否入库成功
        if (!$data) {
            return false;
        }

        return true;
    }

    /**
     * @param array $data
     * @return bool
     * @throws RickException
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function add(array $data): bool
    {
        $inserts['username'] = $data['username'];
        $inserts['password'] = $data['password'];
        $inserts['email'] = $data['email'];
        $inserts['tenantId'] = $data['tenantId'];
        if (!SystemAccount::existence(['field'=>'username','value'=>$data['username']])) {
            throw new RickException('用户名已被使用', Code::FAIL);
        }
        if (!SystemAccount::existence(['field'=>'email','value'=>$data['email']])) {
            throw new RickException('邮箱账号已被使用', Code::FAIL);
        }
        if(!SystemAccount::add($inserts)){
            throw new RickException('添加用户失败', Code::FAIL);
        }
        $user = SystemAccount::where('username',$inserts['username'])->find();
        $role = [
            'userId' => $user['id'],
            'roleId' => $data['roleId']
        ];
        if(!SystemAccountRole::add($role)){
            throw new RickException('配置权限失败', Code::FAIL);
        }
        return true;
    }

    /**
     * @param array $data
     * @return bool
     * @throws DbException
     */
    public function edit(array $data): bool
    {
        $inserts['username'] = $data['username'];
        $inserts['email'] = $data['email'];
        if (!SystemAccount::existence(['id'=>$data['id'],'field'=>'username','value'=>$data['username']])) {
            throw new RickException('用户名已被使用', Code::FAIL);
        }
        if (!SystemAccount::existence(['id'=>$data['id'],'field'=>'email','value'=>$data['email']])) {
            throw new RickException('邮箱账号已被使用', Code::FAIL);
        }
        $role = [
            'roleId' => $data['roleId']
        ];
        // 修改权限信息
        SystemAccountRole::edit($data['id'],$role);
        // 修改用户信息
        SystemAccount::edit($data['id'],$inserts);
        return true;
    }

    /**
     * @param int $id
     * @param string $password
     * @return bool
     * @throws RickException
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function resetPass(int $id, string $password): bool
    {
        //通过Model方法获取用户数据
        $user = SystemAccount::where('id', $id)->find();
        //判断用户数据是否存在
        if (!$user) {
            throw new RickException('用户不存在', Code::FAIL);
        }
        //生成一个密码盐
        $salting = StringUtil::generateRandStr();
        //使用密码盐加密密码
        $password = StringUtil::generatePassword($password, $salting);
        //保存密码盐和密码
        $user->salting = $salting;
        $user->password = $password;
        $data = $user->save();
        //判断是否入库成功
        if (!$data) {
            return false;
        }
        return true;
    }
}