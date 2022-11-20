<?php

namespace app\plugins;

use Alipay\EasySDK\Kernel\Config;
use Alipay\EasySDK\Kernel\Factory;
use App\system\controller\PluginBase;
use app\system\model\UserOrder;
use app\utils\RealUtil;

class AliPay extends PluginBase
{
    /**
     * @var array
     */
    static public array $config = [
        "version" => "1.0.1",
        "name" => "支付宝",
        "icon" => "/static/icon/alipay.png",
        "des" => "支付宝收款对接插件",
        "author" => "ocink",
        "url" => "https://ocink.cn",
        "type" => "pay",
        "data" => [
            "app_id" => [
                "rule" => "require|length:5,32",
                "default" => null,
                "type"  => "text",
                "placeholder"   =>  "请输入应用ID",
                "key" => "APP_ID"
            ],
            "public_key" => [
                "rule" => "require",
                "default" => null,
                "type"  => "textarea",
                "placeholder"   =>  "请输入支付宝公钥",
                "key" => "支付宝公钥"
            ],
            "private_key" => [
                "rule" => "require",
                "default" => null,
                "type"  => "textarea",
                "placeholder"   =>  "请输入支付宝私钥",
                "key" => "应用私钥"
            ]
        ]
    ];

    /**
     * @return Config
     */
    public function getOptions(): Config
    {
        $options = new Config();
        $options->protocol = 'https';
        $options->gatewayHost = 'openapi.alipaydev.com';
        $options->signType = 'RSA2';
        $options->appId = $this->getDataByFileName("Alipay", "app_id");
        $options->merchantPrivateKey = $this->getDataByFileName("Alipay", "private_key");
        $options->alipayPublicKey = $this->getDataByFileName("Alipay", "public_key");

        return $options;
    }

    /**
     * 创建交易
     * @param array $data
     * @param string $client
     * @return string
     */
    public static function create(array $data): string
    {
        $order = $data['order'];
        $title = $data['title'];
        $money = $data['money'];
        $quitUrl = $data['quitUrl'];
        $callback = $data['callback'];
        $returnUrl = $data['returnUrl'];
        //设置支付参数
        Factory::setOptions((new AliPay)->getOptions());
        //发起支付请求
        if(RealUtil::isMobile()){
            $result = Factory::payment()->wap()->asyncNotify($callback)->pay($title, $order, $money, $quitUrl, $returnUrl);
        }else{
            $result = Factory::payment()->page()->asyncNotify($callback)->pay($title, $order, $money, $returnUrl);
        }
        return $result->body;
    }

    /**
     * 异步通知验证
     * @param array $parameters
     * @return string
     */
    public static function notify(array $parameters): string
    {
        //设置支付参数
        Factory::setOptions((new AliPay)->getOptions());
        //处理一下字符
        $parameters['fund_bill_list'] = str_replace('&quot;', '"', $parameters['fund_bill_list']);
        $varify = Factory::payment()->common()->verifyNotify($parameters);
        if ($varify) {
            $data = $parameters;
            //商户订单号
            $out_trade_no = $data['out_trade_no'];
            //支付宝交易号
            $trade_no = $data['trade_no'];
            //交易状态
            $trade_status = $data['trade_status'];
            // TODO 更改订单状态
            $order = UserOrder::where('id',$out_trade_no)->find();
            if($order){
                if ($trade_status == 'TRADE_FINISHED'){$status = 2;}
                if ($trade_status == 'TRADE_SUCCESS'){$status = 1;}
                $update = [
                    'status'    =>  $status,
                    'trade_no'  =>  $trade_no
                ];
                UserOrder::edit($order['id'],$update);
            }
            return "success";        //请不要修改或删除
        }
        return "fail";
    }
}