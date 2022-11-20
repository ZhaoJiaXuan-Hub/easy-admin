<?php

namespace app\system\controller;

use app\constant\Code;
use app\utils\Response\News;
use app\service\system\RoleRoutersServiceInterface;
use support\Request;
use support\Response;

class RoleRoutersController extends SystemBase
{

    const SUCCESS = '查询成功';

    /**
     * @Inject
     * @var RoleRoutersServiceInterface
     */
    private $service;

    /**
     * @param int $roleId
     * @return Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function listRouters(Request $request): Response
    {
        return News::response()->setCode(Code::SUCCESS)
            ->setMessage(self::SUCCESS, $this->listRoleMenus($request->get('roleId')))->output();
    }

    /**
     * @param Request $request
     * @param int $roleId
     * @return Response
     */
    public function updateRoleMenus(Request $request): Response
    {
        if ($this->service->updateRoleMenus($request->post('roleId'), $request->post())) {
            return News::response()->setCode(Code::SUCCESS)
                ->setMessage("修改成功")->output();
        }
        return News::response()->setCode(Code::FAIL)
            ->setMessage("修改失败")->output();
    }
}