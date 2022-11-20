<?php

namespace app\utils;

use think\Model;

class PageUtil
{
    /**
     * @param object $self
     * @param string $key
     * @param array $data
     * @param array $params
     * @param callable $filter
     * @param string|null $json
     * @param string|null $desc
     * @return array
     */
    public static function search(object $self,string $key,array $data,array $params,callable $filter,string $json=null,string $desc=null): array
    {
        $page = $data['page'];
        $pageSize = $data['limit'];
        $page = ($page < 1) ? 1 : $page;
        $pageSize = ($pageSize < 1 || $pageSize > 100) ? 10 : $pageSize;
        $query = $self->alias('a');
        foreach ($params as $k=>$v){
            switch ($v){
                case 'select':
                    isset($data[$k]) && $query->where('a.'.$k, $data[$k]);
                    break;
                case 'createTimeStart':
                    if(!empty($data[$k])){
                        $times = explode(" 到 ",$data[$k]);
                        var_dump($times);
                        $query->whereBetweenTime('a.'.$k,$times[0], $times[1]);
                    }
                    break;
                case  'like':
                    !empty($data[$k]) && $query->whereLike('a.'.$k, '%'.$data[$k].'%');
                    break;
                default:
                    !empty($data[$k]) && $query->where('a.'.$k, $data[$k]);
            }
        }
        if($json!=null){
            $query->json([$json]);
        }
        if(isset($data['sort'])){
            $query->page($page, $pageSize)->order('a.'.$data['sort'].' '.$data['order'].'');
        }else{
            if($desc==null){
                $query->page($page, $pageSize)->order('a.'.$key.' desc');
            }else{
                $query->page($page, $pageSize)->order('a.'.$desc.' desc');
            }
        }
        $query2 = clone $query;
        $list = $query->filter($filter)->select();
        return [
            'count' => $query2->count('a.'.$key),
            'list' => $list
        ];
    }
}