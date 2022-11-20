<?php

namespace app\system\model;

use app\utils\DateUtil;
use app\utils\PageUtil;
use think\Model;

class SystemPlugins extends Model
{
    public static function search(array $data): array
    {
        $params = ['name' => 'text', 'status' => 'select'];
        return PageUtil::search(new static(), 'id', $data, $params, function ($item) {
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
        if ($self->where('id', '=', $id)->update($data)) {
            return true;
        } else {
            return false;
        }
    }

    public
    static function delByPayId($id): bool
    {
        if (self::where('id', $id)->delete()) {
            return true;
        } else {
            return false;
        }
    }

    public
    static function batchDelByRoleId($data): bool
    {
        foreach ($data as $v) {
            self::delByPayId($v);
        }
        return true;
    }
}