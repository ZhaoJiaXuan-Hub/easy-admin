<?php
declare(strict_types=1);

namespace app\middleware\common;

use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

class VerifyMiddleware implements MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
        $response = $request->method() == 'OPTIONS' ? response('') : $handler($request);

        $response->withHeaders([
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Allow-Origin' => $request->header('Origin', '*'),
            'Access-Control-Allow-Methods' => '*',
            'Access-Control-Allow-Headers' => '*',
        ]);
        return $response;
    }
}