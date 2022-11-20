<?php

namespace App\system\controller;

use app\constant\Code;
use app\system\model\UserOrder;
use app\utils\Response\News;
use support\Response;

class OrderController extends SystemBase
{
    const SUCCESS = '查询成功';

    /**
     * @return Response
     */
    public function page(): Response
    {
        $data = request()->get();
        return News::response()->setCode(Code::SUCCESS)
            ->setMessage(self::SUCCESS, UserOrder::search($data))->output();
    }

    /**
     * @return Response
     */
    public function edit(): Response
    {
        $data = request()->post();
        if(UserOrder::edit($data['id'],$data)){
            return News::response()->setCode(Code::SUCCESS)
                ->setMessage('编辑成功')->output();
        }
        return News::response()->setCode(Code::FAIL)
            ->setMessage('编辑失败')->output();
    }

    /**
     * @return Response
     */
    public function del(): Response
    {
        if (UserOrder::delById(request()->post('id'))){
            return News::response()->setCode(Code::SUCCESS)
                ->setMessage('删除成功')->output();
        }
        return News::response()->setCode(Code::FAIL)
            ->setMessage('删除失败')->output();
    }

    /**
     * @return Response
     */
    public function batch(): Response
    {
        $data = request()->post();
        if (UserOrder::batchDelById($data)){
            return News::response()->setCode(Code::SUCCESS)
                ->setMessage('删除成功')->output();
        }
        return News::response()->setCode(Code::FAIL)
            ->setMessage('删除失败')->output();
    }
}