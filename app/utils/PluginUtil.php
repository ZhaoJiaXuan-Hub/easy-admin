<?php

namespace app\utils;

class PluginUtil
{
    /**
     * 获取插件详细配置列表
     * @return array
     */
    public static function getPluginConfigList():array
    {
        $self = new static();
        $list = $self::getPluginFileNameList();
        $config = [];
        foreach ($list as $value){
            $config[$value] = $self::getPluginConfigByFileName($value);
        }
        return $config;
    }

    /**
     * 根据插件类型获取插件详细配置列表
     * @param string $type
     * @return array
     */
    public static function getPluginConfigListByType(string $type):array
    {
        $self = new static();
        $list = $self::getPluginConfigList();
        $config = [];
        foreach ($list as $key=>$value){
            if($value["type"]==$type){
                $config[$key] = $value;
            }
        }
        return $config;
    }

    /**
     * 获取插件目录文件名称列表
     * @return array
     */
    public static function getPluginFileNameList():array
    {
        $self = new static();
        $dir = app_path().'/plugins';
        return $self::getFilesListByDir($dir);
    }

    /**
     * 根据插件文件名获取初始化JSON数据
     * @return array
     */
    public static function getPluginLoadDataByFileName(string $name):array
    {
        $self = new static();
        $data = $self::getPluginConfigByFileName($name);
        $data = $data['data'];
        $jsonData = [];
        foreach ($data as $key=>$value){
            $jsonData[$key] = $value["default"];
        }
        return $jsonData;
    }

    /**
     * 根据插件文件名获取表单数据
     * @return array
     */
    public static function getPluginLoadDataInputByFileName(string $name):array
    {
        $self = new static();
        $data = $self::getPluginConfigByFileName($name);
        return $data['data'];
    }

    /**
     * 验证插件是否存在
     * @param string $name
     * @return bool
     */
    public static function isExistPlugin(string $name):bool
    {
        $self = new static();
        $list = $self::getPluginFileNameList();
        $is = false;
        foreach ($list as $value){
            if($value==$name){
                $is = true;
                break;
            }
        }
        return $is;
    }

    /**
     * 验证插件类型是否存在
     * @param string $type
     * @return bool
     */
    public static function isExistPluginType(string $type):bool
    {
        $self = new static();
        $list = ["pay","tool"];
        $is = false;
        foreach ($list as $value){
            if($value==$type){
                $is = true;
                break;
            }
        }
        return $is;
    }

    /**
     * 通过插件文件名称获取插件配置信息
     * @param $name
     * @return array
     */
    public static function getPluginConfigByFileName($name):array
    {
        $className = '\app\plugins\\'.$name;
        $obj = new $className();
        return $obj::$config;
    }

    /**
     * 通过文件目录地址获取所有PHP文件名称
     * @param string $dir
     * @return array
     */
    public static function getFilesListByDir(string $dir):array
    {
        $pathList = glob($dir.'/*.php');
        $res = [];
        var_dump($pathList);
        foreach ($pathList as $key => $value) {
            $res[] = basename($value,'.php');
        }
        return $res;
    }

    /**
     * 通过支付插件文件名发起交易
     * @param string $name
     * @param array $param
     * @return string
     */
    public static function getCreatePayByFileName(string $name,array $param):string
    {
        $className = '\app\plugins\\'.$name;
        $obj = new $className();
        return $obj::create($param);
    }

    /**
     * 通过支付插件文件名异步通知
     * @param string $name
     * @param array $param
     * @return string
     */
    public static function getNotifyPayByFileName(string $name,array $param):string
    {
        $className = '\app\plugins\\'.$name;
        $obj = new $className();
        return $obj::notify($param);
    }
}