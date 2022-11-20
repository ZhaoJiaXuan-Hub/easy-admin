<?php

namespace app\service\system;

interface RoleRoutersServiceInterface
{
    public function updateRoleMenus(int $roleId,array $data): bool;
}