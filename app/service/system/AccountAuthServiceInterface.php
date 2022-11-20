<?php
declare(strict_types=1);

namespace app\service\system;
use support\Request;

interface AccountAuthServiceInterface
{
    public function login(Request $request,array $data): string;

    public function captcha(Request $request): string;
}