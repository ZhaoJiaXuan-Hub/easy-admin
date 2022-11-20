<?php

namespace app\system\model;

use app\utils\DateUtil;
use app\utils\PageUtil;
use app\utils\StringUtil;
use think\Model;

class SystemRouter extends Model
{
    public static function search(array $data): array
    {
        $self = new static();
        $query = $self->alias('a');
        $params = ['title' => 'text', 'path' => 'text', 'authority' => 'text'];
        foreach ($params as $k => $v) {
            switch ($v) {
                case 'select':
                    isset($data[$k]) && $query->where('a.' . $k, $data[$k]);
                    break;
                case 'createTimeStart':
                    !empty($data['createTimeStart']) && $query->whereBetweenTime('createTime', $data['createTimeStart'], $data['createTimeEnd']);
                    break;
                case  'like':
                    !empty($data[$k]) && $query->whereLike('a.' . $k, '%' . $data[$k] . '%');
                    break;
                default:
                    !empty($data[$k]) && $query->where('a.' . $k, $data[$k]);
            }
        }
        isset($data['sort']) && $query->order('a.' . $data['sort'] . ' ' . $data['order'] . '');

        return $query->select()->toArray();
    }

    public static function add($data): bool
    {
        $self = new static();
        if(isset($data['hide'])){
            $data['hide'] = 0;
        }else{
            $data['hide'] = 1;
        }
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
        if(isset($data['hide'])){
            $data['hide'] = 0;
        }else{
            $data['hide'] = 1;
        }
        $data['updateTime'] = DateUtil::current();
        if ($self->where('menuId', '=', $id)->update($data)) {
            return true;
        } else {
            return false;
        }
    }

    public
    static function delByMenuId($id): bool
    {
        $self = new static();
        if ($self->where('menuId', '=', $id)->delete()) {
            SystemRoleRouters::delByMenuId($id);
            return true;
        } else {
            return false;
        }
    }
}