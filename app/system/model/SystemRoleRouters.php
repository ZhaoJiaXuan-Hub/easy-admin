<?php

namespace app\system\model;

use app\utils\DateUtil;
use app\utils\StringUtil;
use think\Model;

class SystemRoleRouters extends Model
{
    /**
     * @param $roleId
     * @return bool|array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getRouterList($roleId): bool|array
    {
        $self = new static();
        if ($result = $self->where('roleId', '=', $roleId)->order('sort des')->select()) {
            $router = [];
            foreach ($result as $v) {
                $router[] = SystemRouter::where('menuId', '=', $v['menuId'])->find();
            }
            $menu = [];
            foreach ($router as $key=>$value){
                if($value['type'] == 0 && $value['hide'] == 0){
                    $menu[$key]=$value;
                }
            }
            return $self->treeMenu($menu);
        } else {
            return [];
        }
    }
    /**
     * @param $roleId
     * @return bool|array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getRouterListNotMenu($roleId): bool|array
    {
        $self = new static();
        if ($result = $self->where('roleId', '=', $roleId)->order('sort des')->select()) {
            $routers = [];
            foreach ($result as $v) {
                $routers[] = SystemRouter::where('menuId', '=', $v['menuId'])->find();
            }
            return $routers;
        } else {
            return false;
        }
    }

    public static function treeMenu($cate , $pid = 0 , $level = 0 )
    {
        $self = new static();
        $arr = [];
        foreach($cate as $k => $v){
            if($v['parentId'] == $pid) {
                $data = [];
                $data['title'] = $v['title'];
                if($v['path']!=null){
                    $data['jump'] = $v['path'];
                }
                if($v['icon']!=null){
                    $data['icon'] = $v['icon'];
                }
                unset($cate[$k]); //删除该节点，减少递归的消耗
                $data['list'] = $self->treeMenu($cate, $v['menuId'], $level + 1);
                $arr[] = $data;
            }
        }
        return $arr;
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
        if ($self->where('roleId', '=', $id)->update($data)) {
            return true;
        } else {
            return false;
        }
    }

    public
    static function delByRoleId($id): bool
    {
        $self = new static();
        if ($self->where('roleId', '=', $id)->delete()) {
            return true;
        } else {
            return false;
        }
    }

    public
    static function delByMenuId($id): bool
    {
        $self = new static();
        if ($self->where('MenuId', '=', $id)->delete()) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkRoleId($data): bool
    {
        $self = new static();
        if ($self->where("roleId", $data)->find()) {
            return true;
        } else {
            return false;
        }
    }
}