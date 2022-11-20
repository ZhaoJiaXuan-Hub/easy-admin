<?php

namespace app\service\system\socket;

use app\system\model\SystemRole;
use app\system\model\SystemRoleRouters;
use app\utils\DateUtil;
use app\constant\Code;
use app\exception\RickException;
use app\service\System\RoleRoutersServiceInterface;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

class RoleRoutersService implements RoleRoutersServiceInterface
{

    /**
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     * @throws RickException
     */
    public function updateRoleMenus(int $roleId, array $data): bool
    {
        if(!SystemRole::where('roleId', '=', $roleId)->find()){
            throw new RickException('角色ID不存在', Code::FAIL);
        }
        SystemRoleRouters::where('roleId','=',$roleId)->delete();
        if (empty($data)){
            return true;
        }
        unset($data['roleId']);
        $inserts = [];
        foreach($data as $v){
            $inserts[] = [
                'roleId'    =>  $roleId,
                'menuId'    =>  $v,
                'sort'    =>  $v,
                'createTime'    =>  DateUtil::current()
            ];
        }
        if(SystemRoleRouters::insertAll($inserts)){
            return true;
        }
        return false;
    }
}