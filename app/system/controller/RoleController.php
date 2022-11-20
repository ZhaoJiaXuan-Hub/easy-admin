<?php

namespace app\system\controller;

use app\constant\Code;
use app\system\model\SystemRole;
use app\utils\Response\News;
use support\Request;
use support\Response;

class RoleController extends SystemBase
{

    const SUCCESS = '查询成功';

    /**
     * @param Request $request
     * @return Response
     */
    public function pageRoles(Request $request): Response
    {
        $data = $request->get();
        return News::response()->setCode(Code::SUCCESS)
            ->setMessage(self::SUCCESS, SystemRole::search($data))->output();
    }

    /**
     * @return Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getList(): Response
    {
        return News::response()->setCode(Code::SUCCESS)
            ->setMessage(self::SUCCESS, SystemRole::where("deleted",0)->select()->toArray())->output();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $data = $request->post();
        $data['userId'] = $this->getUserId();
        $data['deleted'] = 0;
        if (SystemRole::add($data)) {
            return News::response()->setCode(Code::SUCCESS)
                ->setMessage('添加成功')->output();
        }
        return News::response()->setCode(Code::FAIL)
            ->setMessage('添加失败')->output();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request): Response
    {
        $data = $request->post();
        if (SystemRole::edit($request->post('roleId'), $data)) {
            return News::response()->setCode(Code::SUCCESS)
                ->setMessage('编辑成功')->output();
        }
        return News::response()->setCode(Code::FAIL)
            ->setMessage('编辑失败')->output();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function del(Request $request): Response
    {
        if (SystemRole::delByRoleId($request->post('roleId'))) {
            return News::response()->setCode(Code::SUCCESS)
                ->setMessage('删除成功')->output();
        }
        return News::response()->setCode(Code::FAIL)
            ->setMessage('删除失败')->output();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function batch(Request $request): Response
    {
        $data = $request->post();
        if (SystemRole::batchDelByRoleId($data)) {
            return News::response()->setCode(Code::SUCCESS)
                ->setMessage('删除成功')->output();
        }
        return News::response()->setCode(Code::FAIL)
            ->setMessage('删除失败')->output();
    }
}