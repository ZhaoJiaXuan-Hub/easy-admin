<?php

namespace app\service\api\socket;

use app\constant\Auth;
use app\constant\Code;
use app\exception\RickException;
use app\service\api\V1ServiceInterface;
use app\system\model\SystemPlugins;
use app\system\model\UserOrder;
use app\utils\PluginUtil;

class V1Service implements V1ServiceInterface
{
    public function getPayTypes():array
    {
        $plugins = PluginUtil::getPluginConfigListByType("pay");
        $pay = [];
        foreach ($plugins as $key=>$value){
            $info = SystemPlugins::where('fileName',$key)->find();
            if($info){
                if($info['status']==1){
                    $pay[]=[
                        'name'  =>  $value['name'],
                        'code'  =>  $key,
                        'icon'  =>  Auth::SYSTEM_HTTP . request()->host().$value['icon']
                    ];
                }
            }
        }
        return [
            "default"   =>  !empty($pay[0]['code'])? $pay[0]['code']:null,
            "list"  =>  $pay
        ];
    }

    public function create(array $data):array
    {
        $order = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        if(!PluginUtil::isExistPlugin($data['pay'])){
            throw new RickException('支付插件不存在', Code::FAIL);
        }
        $plugin = PluginUtil::getPluginConfigByFileName($data['pay']);
        if($plugin['type']!="pay"){
            throw new RickException('调用插件类型错误', Code::FAIL);
        }
        $parame = [
            'id'    =>  $order,
            'name'  =>  "平台服务",
            'money' =>  1,
            'type'  =>  $plugin['name'],
            'plugin'    =>  $data['pay']
        ];
        if(!UserOrder::add($parame)){
            throw new RickException('创建订单失败', Code::FAIL);
        }
        return ['pay_url'=>Auth::SYSTEM_HTTP . request()->host()."/api/v1/pay?order=".$order];
    }

    public function pay(string $order):string
    {
        $info = UserOrder::where('id',$order)->find();
        if(!$info){
            throw new RickException('订单不存在', Code::FAIL);
        }
        if($info['status']!=0){
            throw new RickException('此订单已无法支付', Code::FAIL);
        }
        $data = [
            'order' =>  $info['id'],
            'title' =>  $info['name'],
            'money' =>  $info['money'],
            'quitUrl'   =>  Auth::WEB_URL,
            'callback'  =>  Auth::SYSTEM_HTTP .  request()->host()."/api/v1/notify",
            'returnUrl' =>  Auth::WEB_URL
        ];
        return PluginUtil::getCreatePayByFileName($info['plugin'],$data);
    }

    public function notify(array $data):string
    {
        $out_trade_no = $data['out_trade_no'];
        $order = UserOrder::where('id',$out_trade_no)->find();
        if(!$order){
            throw new RickException('订单不存在', Code::FAIL);
        }
        return PluginUtil::getNotifyPayByFileName($order['plugin'],$data);
    }
}