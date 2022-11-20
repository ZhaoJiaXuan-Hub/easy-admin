<?php

namespace app\system\model;

use app\utils\DateUtil;
use think\Model;

class SystemAccountRole extends Model
{
    /**
     * @param $userId
     * @return SystemAccountRole|array|false|mixed|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getRoleList($userId)
    {
        $self = new static();
        if ($result = $self->where('userId', '=', $userId)->select()) {
            $roles = [];
            foreach ($result as $v) {
                $roles[] = SystemRole::where('roleId', '=', $v['roleId'])->find();
            }
            return $roles;
        } else {
            return false;
        }
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
        if ($self->where('userId', '=', $id)->update($data)) {
            return true;
        } else {
            return false;
        }
    }

    public static function delByUserId($id): bool
    {
        $self = new static();
        if ($self->where('userId', '=', $id)->delete()) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkUserId($data): bool
    {
        $self = new static();
        if ($row = $self->where("userId", $data)->find()) {
            return true;
        } else {
            return false;
        }
    }
}