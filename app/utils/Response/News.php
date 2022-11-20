<?php
declare(strict_types=1);

namespace app\utils\Response;

use app\constant\Code;

class News
{

    //创建静态私有的变量保存该类对象
    static private $instance;

    //防止使用new直接创建对象
    private function __construct()
    {
        $this->initialize();
    }

    //防止使用clone克隆对象
    private function __clone()
    {
    }

    private function initialize()
    {
        $this->code = Code::FAIL;
        $this->message = [];
        $this->count = 0;
    }

    static public function response(): News
    {
        //判断$instance是否是Singleton的对象，不是则创建
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private int $code = Code::FAIL;

    private array $message = [];

    private int $count = 0;

    public function setCode(int $code): News
    {
        $this->code = $code;
        return self::response();
    }

    public function setMessage(string $message, array $data = null): News
    {
        if (!empty($message)) {
            $this->message['message'] = $message;
        }

        if (is_array($data)) {
            $this->message['data'] = $data;
        }
        return self::response();
    }

    public function setCount(int $count): News
    {
        $this->count = $count;
        return self::response();
    }


    public function output()
    {
        $content = [];

        $code = $this->code;
        $message = $this->message;
        $count = $this->count;

        $this->initialize();

        $content['code'] = $code;

        if (!empty($message)) {
            foreach ($message as $key => $value) {
                $content[$key] = $value;
            }
        }

        if (!empty($count)) {
            $content['count'] = $count;
        }

        return json($content);
    }
}