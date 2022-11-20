<?php

namespace app\api\controller;

use think\facade\Db;

class ApiBase
{
    static public array $config = [];

    public function __construct()
    {
        $config = Db::name('configs')->column('v', 'k');
        static::$config = $config;
    }
}