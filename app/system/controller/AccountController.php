<?php

namespace app\system\controller;

use app\constant\Code;
use app\exception\RickException;
use app\service\system\AccountServiceInterface;
use app\system\model\SystemAccount;
use app\utils\Response\News;
use support\Request;
use support\Response;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

class AccountController extends SystemBase
{
    const SUCCESS = '查询成功';

    /**
     * @Inject
     * @var AccountServiceInterface
     */
    private $service;


    /**
     * @param Request $request
     * @return Response
     * @throws DbException
     * @throws RickException
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     */
    public function getAccount(Request $request): Response
    {
        return News::response()->setCode((int)Code::SUCCESS)
            ->setMessage(self::SUCCESS, $this->getUserInfo($request))
            ->output();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function editPass(Request $request): Response
    {
        $map = $request->post();
        $map['id'] = $this->getUserId();
        if ($this->service->editPass($map)) {
            return News::response()->setCode(Code::SUCCESS)
                ->setMessage('更新用户信息成功，你的新密码是：' . $map['password'])
                ->output();
        }

        return News::response()->setCode(Code::FAIL)->setMessage('修改失败')->output();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function page(Request $request): Response
    {
        $data = $request->get();
        return News::response()->setCode(Code::SUCCESS)
            ->setMessage(self::SUCCESS, SystemAccount::search($data))->output();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $map = $request->post();
        $map['tenantId'] = $this->getUserId();
        if ($this->service->add($map)) {
            return News::response()->setCode(Code::SUCCESS)
                ->setMessage("添加成功")->output();
        }
        return News::response()->setCode(Code::FAIL)
            ->setMessage("添加失败")->output();
    }

    /**
     * @param Request $request
     * @return \support\Response
     */
    public function edit(Request $request): Response
    {
        $map = $request->post();
        if ($this->service->edit($map)) {
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
    public function password(Request $request): Response
    {
        $map = $request->post();
        if ($this->service->resetPass($map['id'], $map['password'])) {
            return News::response()->setCode(Code::SUCCESS)
                ->setMessage('更新用户信息成功，你的新密码是：' . $map['password'])
                ->output();
        }
        return News::response()->setCode(Code::FAIL)->setMessage('修改失败')->output();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function existence(Request $request): Response
    {
        $data = $request->get();
        if (isset($data['id'])) {
            if ($user = SystemAccount::checkField('id', $data['id'])) {
                if ($user[$data['field']] == $data['value']) {
                    return News::response()->setCode(Code::FAIL)
                        ->setMessage("字段值可用")->output();
                }
            }
        }
        if (!SystemAccount::checkField($data['field'], $data['value'])) {
            return News::response()->setCode(Code::FAIL)
                ->setMessage("字段值可用")->output();
        }
        return News::response()->setCode(Code::SUCCESS)
            ->setMessage("字段值存在")->output();
    }

    /**
     * @param Request $request
     * @return Response
     * @throws DbException
     */
    public function del(Request $request): Response
    {
        $map = $request->post();
        if (SystemAccount::delById($map['id'])) {
            return News::response()->setCode(Code::SUCCESS)
                ->setMessage('删除成功')->output();
        }
        return News::response()->setCode(Code::FAIL)
            ->setMessage('删除失败')->output();
    }

    /**
     * @param Request $request
     * @return Response
     * @throws DbException
     */
    public function batch(Request $request): Response
    {
        $data = $request->post();
        if (SystemAccount::batchDelById($data)) {
            return News::response()->setCode(Code::SUCCESS)
                ->setMessage('删除成功')->output();
        }
        return News::response()->setCode(Code::FAIL)
            ->setMessage('删除失败')->output();
    }

    /**
     * @param Request $request
     * @return Response
     * @throws DbException
     */
    public function status(Request $request): Response
    {
        $data = $request->post();
        if (!SystemAccount::edit($data['userId'], ['status' => $data['status']])) {
            return News::response()->setCode(Code::FAIL)
                ->setMessage('更改失败')->output();
        }
        return News::response()->setCode(Code::SUCCESS)
            ->setMessage('更改成功')->output();
    }
}