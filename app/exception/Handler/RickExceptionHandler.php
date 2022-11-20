<?php

namespace app\exception\Handler;

use app\constant\Code;
use app\exception\RickException;
use app\utils\Response\News;
use BadFunctionCallException;
use Exception;
use support\exception\BusinessException;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use Throwable;
use UnexpectedValueException;
use Webman\Exception\ExceptionHandler;
use Webman\Http\Request;
use Webman\Http\Response;
use think\db\exception\DbException;

/**
 * 异常处理
 * Class WinkExceptionHandle
 * @package app\exception\Handle
 */
class RickExceptionHandler extends ExceptionHandler
{
    public $dontReport = [
        ModelNotFoundException::class,
        DataNotFoundException::class,
        BusinessException::class,
    ];

    public function report(Throwable $exception): void
    {
        // 使用内置的方式记录异常日志
        parent::report($exception);
    }

    /**
     * 异常抛出信息
     * @param Request $request
     * @param Throwable $exception
     * @return \support\Response
     */
    public function render(Request $request, Throwable $exception): Response
    {
        if ($exception instanceof RickException) {
            return News::response()
                ->setCode($exception->getCode())
                ->setMessage($exception->getMessage())->output();
        } else if ($exception instanceof DbException || $exception instanceof BadFunctionCallException) {
            return News::response()
                ->setCode(Code::FAIL)
                ->setMessage($exception->getMessage())->output();
        } else if ($exception instanceof UnexpectedValueException) {
            return News::response()
                ->setCode(Code::LOGIN_ERROR)
                ->setMessage($exception->getMessage())->output();
        } else if ($exception instanceof Exception) {
            if ($exception->getMessage() == 'Undefined indexController: id') {
                return News::response()
                    ->setCode(Code::LOGIN_ERROR)
                    ->setMessage($exception->getMessage())->output();
            }
            return News::response()
                ->setCode(Code::FAIL)
                ->setMessage($exception->getMessage())->output();
        }

        return parent::render($request, $exception);
    }
}