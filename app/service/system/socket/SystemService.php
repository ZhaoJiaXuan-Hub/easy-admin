<?php

namespace app\service\system\socket;

use think\facade\Db;
use app\service\System\SystemServiceInterface;

class SystemService implements SystemServiceInterface
{
    public function editConfigs(array $data): bool
    {
        foreach ($data as $k => $value) {
            Db::execute("INSERT INTO ".Config('thinkorm.connections.mysql.prefix')."configs SET k='" . $k . "',v='" . $value . "' ON DUPLICATE KEY UPDATE v='" . $value . "'");
        }
        return true;
    }
}