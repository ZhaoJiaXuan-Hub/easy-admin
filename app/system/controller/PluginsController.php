<?php

namespace app\system\controller;

use app\constant\Code;
use app\service\system\PluginsServiceInterface;
use app\system\model\SystemPlugins;
use app\utils\Response\News;
use support\Request;
use support\Response;

class PluginsController extends SystemBase
{
    const SUCCESS = '查询成功';

    /**
     * @Inject
     * @var PluginsServiceInterface
     */
    private $service;

    /**
     * @param Request $request
     * @return Response
     */
    public function getList(Request $request): Response
    {
        $map = $request->get();
        if (empty($map['type'])) {
            $map['type'] = "all";
        }
        return News::response()->setCode(Code::SUCCESS)
            ->setMessage(self::SUCCESS, $this->service->getPluginList($request,$map["type"]))->output();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getInputList(Request $request): Response
    {
        $map = $request->get();
        return News::response()->setCode(Code::SUCCESS)
            ->setMessage(self::SUCCESS, $this->service->getInputList($map["name"]))->output();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function status(Request $request): Response
    {
        $data = $request->post();
        if (!SystemPlugins::edit($data['id'], ['status' => $data['status']])) {
            return News::response()->setCode(Code::FAIL)
                ->setMessage('更改失败')->output();
        }
        return News::response()->setCode(Code::SUCCESS)
            ->setMessage('更改成功')->output();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function editData(Request $request): Response
    {
        $data = $request->post();
        if (!$this->service->editData($data['id'], $data['data'])) {
            return News::response()->setCode(Code::FAIL)
                ->setMessage('编辑失败')->output();
        }
        return News::response()->setCode(Code::SUCCESS)
            ->setMessage('编辑成功')->output();
    }
}