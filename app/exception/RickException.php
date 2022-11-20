<?php

namespace app\exception;

use app\constant\Code;
use Throwable;


class RickException extends \exception
{
    public function __construct($message = "", $code = Code::FAIL, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}