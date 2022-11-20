<?php

namespace app\system\model;

use app\utils\DateUtil;
use app\utils\PageUtil;
use app\utils\RealUtil;
use think\Model;

class SystemLoginLog extends Model
{
    public static function search(array $data): array
    {
        $params = [
            'username' => "text",
            'ip' => "text",
            'createTime' => "createTimeStart"
        ];
        return PageUtil::search(new static(), 'id', $data, $params, function ($item) {
            return $item;
        });
    }

    public static function add(array $data): bool
    {
        $self = new static();
        $data['ip'] = RealUtil::getRealIp();
        $data['createTime'] = DateUtil::current();
        $data['browser'] = RealUtil::getBrowse();
        $data['osName'] = RealUtil::getOs();
        $data['city'] = RealUtil::getIpCity();

        if ($self->insert($data)) {
            return true;
        } else {
            return false;
        }
    }
}