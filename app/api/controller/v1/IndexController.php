<?php

namespace app\api\controller\v1;

use app\constant\Code;
use app\service\api\V1ServiceInterface;
use app\utils\Response\News;
use support\Response;

class IndexController
{
    /**
     * @Inject
     * @var V1ServiceInterface
     */
    private $service;

    /**
     * 获取支付方式
     * @return Response
     */
    public function getPayTypes(): Response
    {
        return News::response()->setCode(Code::SUCCESS)
            ->setMessage("查询成功",$this->service->getPayTypes())
            ->output();
    }

    /**
     * 创建订单
     * @return Response
     */
    public function create(): Response
    {
        $data = request()->get();
        return News::response()->setCode(Code::SUCCESS)
            ->setMessage("创建订单成功",$this->service->create($data))
            ->output();
    }

    /**
     * 发起支付
     * @return Response
     */
    public function pay(): Response
    {
        $data = request()->get();
        return response($this->service->pay($data['order']));
    }

    /**
     * 支付异步回调
     * @return string
     */
    public function notify(): string
    {
        $data = request()->post();
        return $this->service->notify($data);
    }
}