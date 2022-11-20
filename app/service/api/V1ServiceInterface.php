<?php

namespace app\service\api;

interface V1ServiceInterface
{
    public function getPayTypes():array;

    public function create(array $data):array;

    public function pay(string $order):string;

    public function notify(array $data):string;
}