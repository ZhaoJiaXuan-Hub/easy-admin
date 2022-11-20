<?php

namespace app\system\controller;

use app\constant\Code;
use app\utils\Response\News;
use app\service\system\SystemServiceInterface;
use support\Request;
use support\Response;

class SystemController extends SystemBase
{

    const SUCCESS = '查询成功';

    /**
     * @Inject
     * @var SystemServiceInterface
     */
    private $service;

    /**
     * @param Request $request
     * @return Response
     */
    public function editConfigs(Request $request): Response
    {
        $map = $request->post();
        if ($this->service->editConfigs($map)) {
            return News::response()->setCode(Code::SUCCESS)
                ->setMessage('保存成功')
                ->output();
        }
        return News::response()->setCode(Code::FAIL)->setMessage('修改失败')->output();
    }

    /**
     * @return Response
     */
    public function getConfigs(): Response
    {
        return News::response()->setCode(Code::SUCCESS)->setMessage('获取成功', self::$config)->output();
    }
}