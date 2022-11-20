<?php

namespace app\service\system\socket;

use app\constant\Code;
use app\exception\RickException;
use app\service\System\PluginsServiceInterface;
use app\system\model\SystemPlugins;
use app\utils\DateUtil;
use app\utils\PluginUtil;
use support\Request;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

class PluginsService implements PluginsServiceInterface
{
    public function getPluginList(Request $request,string $type): array
    {
        if($type=="all"){
            $list = PluginUtil::getPluginConfigList();
        }else{
            if(!PluginUtil::isExistPluginType($type)){
                throw new RickException('插件类型不存在', Code::FAIL);
            }
            $list = PluginUtil::getPluginConfigListByType($type);
        }
        $plugins = [];
        foreach ($list as $key=>$value){
            $sql = SystemPlugins::where("fileName",$key)->json(['data'])->find();
            if(!$sql){
                //获取初始化数据
                $loadData = PluginUtil::getPluginLoadDataByFileName($key);
                $create=[
                    "fileName"  =>  $key,
                    "name"  =>  $value['name'],
                    "data"  =>  $loadData,
                    "createTime"    =>  DateUtil::current()
                ];
                SystemPlugins::json(['data'])->insert($create);
                $sql = SystemPlugins::where("fileName",$key)->json(['data'])->find();
            }
            $plugins[] = [
                "id"    =>  $sql['id'],
                "fileName"  =>  $key,
                "name"  =>  $value['name'],
                "icon"  =>  '//' . $request->host().$value['icon'],
                "des"  =>  $value['des'],
                "author"    =>  $value['author'],
                "url"    =>  $value['url'],
                "version"    =>  $value['version'],
                "type"    =>  $value['type'],
                "status"    =>  $sql['status'],
                "data"    =>  $sql['data'],
                "createTime"    =>  $sql['createTime'],
                "updateTime"    =>  $sql['updateTime'],
            ];
        }
        return $plugins;
    }

    public function getInputList(string $name): array
    {
        if (!PluginUtil::isExistPlugin($name)){
            throw new RickException('此插件不存在', Code::FAIL);
        }
        return PluginUtil::getPluginLoadDataInputByFileName($name);
    }

    /**
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     * @throws RickException
     */
    public function editData(int $id, array $data): bool
    {
        $sql = SystemPlugins::where("id",$id)->json(['data'])->find();
        if(!$sql || !PluginUtil::isExistPlugin($sql['fileName'])){
            throw new RickException('需要编辑的插件不存在', Code::FAIL);
        }
        $config = PluginUtil::getPluginConfigByFileName($sql['fileName']);
        $rules = [];
        foreach ($config['data'] as $key=>$value){
            $rules[$key] = $value['rule'];
        }
        $validate = \think\facade\Validate::rule($rules);
        if (!$validate->check($data)) {
            throw new RickException($validate->getError(), Code::FAIL);
        }
        if(!SystemPlugins::where('id', '=', $id)->json(['data'])->update(['data'=>$data])){
            throw new RickException("导入数据出错", Code::FAIL);
        }
        return true;
    }
}