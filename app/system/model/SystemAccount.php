<?php

namespace app\system\model;

use app\constant\Gravatar;
use app\utils\DateUtil;
use app\utils\PageUtil;
use app\utils\StringUtil;
use think\db\exception\DbException;
use think\Model;

class SystemAccount extends Model
{
    /**
     * 查询方法
     * @param array $data
     * @return array
     */
    public static function search(array $data): array
    {
        $params = [
            'username' => "text",
            'email' => "text",
            'status' => "select",
            'createTime'    =>  "createTimeStart"
        ];
        return PageUtil::search(new static(), 'id', $data, $params, function ($item) {
            $item['avatar'] = Gravatar::ADDRESS . md5($item['email']);
            $roles = SystemAccountRole::getRoleList($item['id']);
            $item['role'] = $roles[0];
            return $item;
        });
    }


    /**
     * 增加方法
     * @param array $data
     * @return bool
     */
    public static function add(array $data): bool
    {
        $self = new static();
        $salting = StringUtil::generateRandStr();
        $data['createTime'] = DateUtil::current();
        $data['password'] = StringUtil::generatePassword($data['password'], $salting);
        $data['salting'] = $salting;
        $data['status'] = 1;
        if ($self->insert($data)) {
            return true;
        }
        return false;
    }

    public static function existence(array $data): bool
    {
        $self = new static();
        if (isset($data['id'])) {
            if ($user = $self->checkField('id', $data['id'])) {
                if ($user[$data['field']] == $data['value']) {
                    return true;
                }
            }
        }
        if (!$self->checkField($data['field'], $data['value'])) {
            return true;
        }
        return false;
    }

    /**
     * 编辑方法
     * @param $id
     * @param $data
     * @return bool
     * @throws DbException
     */
    public static function edit($id, $data): bool
    {
        $self = new static();
        if ($self->where('id', '=', $id)->update($data)) {
            return true;
        }
        return false;
    }

    public static function checkField(string $field, string $value)
    {
        $self = new static();
        if ($result = $self->where($field, $value)->find()) {
            return $result;
        }
        return false;
    }

    /**
     * 删除方法
     * @param int $id
     * @return bool
     * @throws DbException
     */
    public static function delById(int $id): bool
    {
        $self = new  static();
        if ($self->where('id', $id)->delete()) {
            SystemAccountRole::delByUserId($id);
            return true;
        }
        return false;
    }

    /**
     * @param $data
     * @return bool
     * @throws DbException
     */
    public static function batchDelById($data): bool
    {
        foreach ($data as $v) {
            self::delById($v);
        }
        return true;
    }
}