<?php
declare(strict_types=1);

namespace app\service\system;

interface AccountServiceInterface
{
    /**
     * 修改密码
     * @param array $data
     * @return bool
     */
    public function editPass(array $data): bool;

    /**
     * 添加用户
     * @param array $data
     * @return bool
     */
    public function add(array $data): bool;

    /**
     * 编辑用户
     * @param array $data
     * @return bool
     */
    public function edit(array $data): bool;

    /**
     * 重置密码
     * @param int $id
     * @param string $password
     * @return bool
     */
    public function resetPass(int $id,string $password): bool;
}