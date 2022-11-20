<?php

namespace app\system\controller;

use app\constant\Code;
use app\constant\Token;
use app\service\system\AccountAuthServiceInterface;
use app\utils\Response\News;
use support\Request;
use support\Response;

class AccountAuthController
{

    /**
     * @Inject
     * @var AccountAuthServiceInterface
     */
    private $service;


    /**
     * @param Request $request
     * @return Response
     */
    public function login(Request $request): Response
    {
        return News::response()->setCode(Code::SUCCESS)
            ->setMessage('登录成功', [
                Token::SYSTEM_TOKEN => $this->service->login($request,$request->post())
            ])->output();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function captcha(Request $request): Response
    {
        return response($this->service->captcha($request),200,['Content-Type' => 'image/jpeg']);
    }
}