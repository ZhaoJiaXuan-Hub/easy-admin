<?php

namespace app\system\model;

use app\utils\DateUtil;
use app\utils\PageUtil;
use think\Model;

class UserOrder extends Model
{
    public
    static function search(array $data): array
    {
        $params=[
            'id' =>  "text",
            'trade_no'  =>  "text",
            'status'  =>  "select",
            'createTime'   =>  "createTimeStart"
        ];
        return PageUtil::search(new static(),'id',$data,$params,function($item) {
            return $item;
        },null,"createTime");
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
    static function delById($id): bool
    {
        $self = new static();
        if ($self->where('id', '=', $id)->delete()) {
            return true;
        } else {
            return false;
        }
    }

    public
    static function batchDelById($data): bool
    {
        foreach($data as $v){
            self::delById($v);
        }
        return true;
    }
}