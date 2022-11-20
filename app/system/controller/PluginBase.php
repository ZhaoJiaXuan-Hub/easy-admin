<?php

namespace App\system\controller;

use app\system\model\SystemPlugins;
use app\utils\DateUtil;
use app\utils\PluginUtil;

class PluginBase
{
    public function getDataByFileName(string $name, string $key): string
    {
        $info = SystemPlugins::where("fileName", $name)->json(['data'])->find();
        $value = PluginUtil::getPluginConfigByFileName($name);
        if (!$info) {
            //获取初始化数据
            $loadData = PluginUtil::getPluginLoadDataByFileName($name);
            $create = [
                "fileName" => $key,
                "name" => $value['name'],
                "data" => $loadData,
                "createTime" => DateUtil::current()
            ];
            SystemPlugins::json(['data'])->insert($create);
            $info = SystemPlugins::where("fileName", $key)->json(['data'])->find()->toArray();
        }
        return $info['data']->$key;
    }
}