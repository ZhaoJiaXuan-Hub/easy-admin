<?php

namespace app\service\system;

use support\Request;

interface PluginsServiceInterface
{
    public function getPluginList(Request $request,string $type): array;

    public function getInputList(string $name): array;

    public function editData(int $id,array $data): bool;
}