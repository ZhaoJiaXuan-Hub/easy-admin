<?php
declare(strict_types=1);

namespace app\utils;

use yzh52521\EasyHttp\Http;

class RealUtil
{

    /**
     * 获取用户IP
     * @return string
     */
    public static function getRealIp():string
    {
        return request()->getRemoteIp();
    }

    /**
     * 获取操作系统
     * @return string
     */
    public static function getOs(): string
    {
        if (!empty(request()->header('user-agent'))) {
            $os = request()->header('user-agent');
            if (preg_match('/win/i', $os)) {
                $os = 'Windows';
            } else if (preg_match('/mac/i', $os)) {
                $os = 'MAC';
            } else if (preg_match('/linux/i', $os)) {
                $os = 'Linux';
            } else if (preg_match('/unix/i', $os)) {
                $os = 'Unix';
            } else if (preg_match('/bsd/i', $os)) {
                $os = 'BSD';
            } else {
                $os = 'Other';
            }
            return $os;
        } else {
            return 'unknown';
        }
    }

    /**
     * 获取浏览器信息
     * @return string
     */
    public static function getBrowse(): string
    {
        if (!empty(request()->header('user-agent'))) {
            $br = request()->header('user-agent');
            if (preg_match('/MSIE/i', $br)) {
                $br = 'MSIE';
            } else if (preg_match('/Firefox/i', $br)) {
                $br = 'Firefox';
            } else if (preg_match('/Chrome/i', $br)) {
                $br = 'Chrome';
            } else if (preg_match('/Safari/i', $br)) {
                $br = 'Safari';
            } else if (preg_match('/Opera/i', $br)) {
                $br = 'Opera';
            } else {
                $br = 'Other';
            }
            return $br;
        } else {
            return 'unknown';
        }
    }

    /**
     * 根据IP获取城市
     * @param string $ip
     * @return string
     */
    public static function getIpCity(string $ip = ''): string
    {
        $ip = empty($ip) ? request()->getRemoteIp() : $ip;
        $url = 'http://whois.pconline.com.cn/ipJson.jsp?json=true&ip='.$ip;
        $response = Http::get($url);
        $data = trim((string)$response->body());
        $data = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data);
        $data = json_decode($data,true);
        if($data['city']==null){
            $result = '未知地址';
        }else{
            $result = $data['pro']." ".$data['city']." ".$data['region'];;
        }
        return $result;
    }

    /**
     * 判断是否移动端
     * @return bool
     */
    public static function isMobile(): bool
    {
        if (request()->header('http-via') && stristr(request()->header('http-via'), "wap")) {
            return true;
        } elseif (request()->header('http-accept') && strpos(strtoupper(request()->header('http-accept')), "VND.WAP.WML")) {
            return true;
        } elseif (request()->header('http-x-wap-profile') || request()->header('http-profile')) {
            return true;
        } elseif (request()->header('user-agent') && preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', request()->header('user-agent'))) {
            return true;
        }

        return false;
    }
}