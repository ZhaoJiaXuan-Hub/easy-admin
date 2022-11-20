<?php

namespace app\system\controller;

use app\constant\Code;
use app\system\model\SystemLoginLog;
use app\utils\Response\News;
use support\Request;
use support\Response;

class LoginLogController extends SystemBase
{

    const SUCCESS = '查询成功';

    /**
     * @param Request $request
     * @return Response
     */
    public function page(Request $request): Response
    {
        $data = $request->get();
        return News::response()->setCode(Code::SUCCESS)
            ->setMessage(self::SUCCESS, SystemLoginLog::search($data))->output();
    }

    /**
     * @return Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getList(): Response
    {
        if (!$list = SystemLoginLog::where(1)->select()) {
            return News::response()->setCode(Code::FAIL)
                ->setMessage("获取失败",)->output();
        }
        return News::response()->setCode(Code::SUCCESS)
            ->setMessage(self::SUCCESS, $list->toArray())->output();
    }
}