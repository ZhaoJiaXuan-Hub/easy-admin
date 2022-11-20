<?php

namespace app\system\model;

use app\system\controller\SystemBase;
use app\utils\DateUtil;
use app\utils\PageUtil;
use think\Model;

class SystemRole extends Model
{
    public static function search(array $data): array
    {
        $data['deleted'] = 0;
        $params = ['roleName' => 'text', 'roleCode' => 'text', 'comments' => 'like', 'deleted' => 'select'];
        return PageUtil::search(new static(), 'roleId', $data, $params, function ($item) {
            return $item;
        });
    }

    public static function add($data): bool
    {
        $self = new static();
        $data['createTime'] = DateUtil::current();
        if ($self->insert($data)) {
            return true;
        } else {
            return false;
        }
    }

    public static function edit($id, $data): bool
    {
        $self = new static();
        $data['updateTime'] = DateUtil::current();
        if ($self->where('roleId', '=', $id)->update($data)) {
            return true;
        } else {
            return false;
        }
    }

    public
    static function delByRoleId($id): bool
    {
        if($id == SystemBase::$config['default_role']){
            return false;
        }
        if (self::where('roleId',$id)->delete()) {
            SystemAccountRole::where('roleId',$id)->update(['roleId'=>SystemBase::$config['default_role']]);
            SystemRoleRouters::where('roleId',$id)->delete();
            return true;
        } else {
            return false;
        }
    }

    public
    static function batchDelByRoleId($data): bool
    {
        foreach ($data as $v) {
            self::delByRoleId($v);
        }
        return true;
    }
}