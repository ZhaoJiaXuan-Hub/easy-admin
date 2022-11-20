<?php

namespace app\service\system;

interface SystemServiceInterface
{
    public function editConfigs(array $data): bool;
}