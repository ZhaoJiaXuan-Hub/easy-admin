<?php

namespace app\system\controller;

use app\constant\Code;
use app\system\model\SystemRouter;
use app\utils\Response\News;
use support\Request;
use support\Response;

class RouterController extends SystemBase
{

    const SUCCESS = '查询成功';

    /**
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $data = $request->post();
        if (SystemRouter::add($data)) {
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
        if (SystemRouter::edit($data['menuId'], $data)) {
            return News::response()->setCode(Code::SUCCESS)
                ->setMessage('编辑成功')->output();
        }
        return News::response()->setCode(Code::FAIL)
            ->setMessage('编辑失败')->output();
    }

    /**
     * @param int $menuId
     * @return Response
     */
    public function del(Request $request): Response
    {
        if (SystemRouter::delByMenuId($request->post('menuId'))) {
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
    public function menuList(Request $request): Response
    {
        $data = $request->get();
        return News::response()->setCode(Code::SUCCESS)
            ->setMessage(self::SUCCESS, SystemRouter::search($data))->output();
    }

}