<?php

namespace app\api\service;

class Union
{
    const TOKEN_URI = '/api/api/v1/token';
    const CERTIFICATE_URI = '/api/api/v1/nc/getUserByNameAndCertificateNo';
    const SYS_ALL_URI = '/api/api/v1/sys/dict';
    const SYS_TYPE_URI = '/api/api/v1/sys/dict';
    const AREA_ALL_URI = '/api/api/v1/sys/area/findAll';
    const CHILD_AREA_ALL_URI = '/api/api/v1/sys/area/findChildArea';
    const LOWER_LEVEL_AREA_URI = '/api/api/v1/sys/area/findLowerLevelArea';

    public function getAccessToken()
    {
        $url = config('union.req_url').self::TOKEN_URI . '?username=' . config('union.username') . '&password='.config('union.password');
        $result = json_decode(\Http::get($url),true);
        if($result['code'] == 200 && $result['msg'] == 'OK'){
            return $result['data']['accessToken'];
        }
        return '';
    }

    public function getUserByNameAndCertificateNo($params = [], $access_token = '')
    {
        $time = time();
        $queryarr = [
            "username" => [config('union.username')],
            "timestamp" => ["$time"],
            'certificateNo' => [$params['id_number']],
            'name' => [$params['username']],
        ];
        $querystr = json_encode($queryarr,JSON_UNESCAPED_UNICODE);
        $digest = hash_hmac('sha256', $querystr, $access_token);
        $str = 'username=' . config('union.username') . '&timestamp=' . $time . '&certificateNo=' . $params['id_number'] . '&name=' . $params['username'] . '&digest=' . $digest;
        $result = json_decode(\Http::post(config('union.req_url') . self::CERTIFICATE_URI,$str),true);
        return $result;
    }

    /**
     * 获取所有字典字段信息
     * @param $access_token
     * @return mixed
     */
    public function getAllSysData($access_token)
    {
        $time = time();
        $queryarr = [
            "username" => [config('union.username')],
            "timestamp" => ["$time"],
        ];
        $querystr = json_encode($queryarr,JSON_UNESCAPED_UNICODE);
        $digest = hash_hmac('sha256', $querystr, $access_token);
        $str = '?username=' . config('union.username') . '&timestamp=' . $time . '&digest=' . $digest;
        $result = json_decode(\Http::get(config('union.req_url') . self::SYS_ALL_URI.$str),true);
        return $result;
    }

    /**
     * 根据类型列出字典
     * @param $access_token
     * @param $type
     * @return mixed
     */
    public function getSysData($access_token , $type)
    {
        $time = time();
        $queryarr = [
            "username" => [config('union.username')],
            "timestamp" => ["$time"],
            "type" => ["$type"],
        ];
        $querystr = json_encode($queryarr,JSON_UNESCAPED_UNICODE);
        $digest = hash_hmac('sha256', $querystr, $access_token);
        $str = '?username=' . config('union.username') . '&timestamp=' . $time . "&type={$type}" . '&digest=' . $digest;
//        dump(config('union.req_url') . self::SYS_TYPE_URI.'/'.$type.$str);
        $result = json_decode(\Http::get(config('union.req_url') . self::SYS_TYPE_URI.'/'.$type.$str),true);
        if($result['code'] == 200){
            return $result['data'];
        }
        return [];
    }

    /**
     * 列出所有区域
     * @param $access_token
     * @return mixed
     */
    public function getAreaAll($access_token)
    {
        $time = time();
        $queryarr = [
            "username" => [config('union.username')],
            "timestamp" => ["$time"],
        ];
        $querystr = json_encode($queryarr,JSON_UNESCAPED_UNICODE);
        $digest = hash_hmac('sha256', $querystr, $access_token);
        $str = '?username=' . config('union.username') . '&timestamp=' . $time . '&digest=' . $digest;
//        dump(config('union.req_url') . self::AREA_ALL_URI.$str);die;
        $result = json_decode(\Http::get(config('union.req_url') . self::AREA_ALL_URI.$str),true);
        return $result;
    }

    /**
     * 根据区域ID列出下属区域
     * @param $access_token
     * @param string $id
     * @return mixed
     */
    public function getChildAreaAll($access_token, $id = '10010')
    {
        $time = time();
        $queryarr = [
            "username" => [config('union.username')],
            "timestamp" => ["$time"],
            "id" => ["$id"],
        ];
        $querystr = json_encode($queryarr,JSON_UNESCAPED_UNICODE);
        $digest = hash_hmac('sha256', $querystr, $access_token);
        $str = '?username=' . config('union.username') . '&timestamp=' . $time . '&id=10010' . '&digest=' . $digest;
        $result = json_decode(\Http::get(config('union.req_url') . self::CHILD_AREA_ALL_URI.'/'.$id.$str),true);
        return $result;
    }

    /**
     * 根据区域ID列出下一级区域
     * @param $access_token
     * @param string $id
     * @return mixed
     */
    public function getLowerLevelArea($access_token, $id = '10010')
    {
        $time = time();
        $queryarr = [
            "username" => [config('union.username')],
            "timestamp" => ["$time"],
            "id" => ["$id"],
        ];
        $querystr = json_encode($queryarr,JSON_UNESCAPED_UNICODE);
        $digest = hash_hmac('sha256', $querystr, $access_token);
        $str = '?username=' . config('union.username') . '&timestamp=' . $time . '&id=10010' . '&digest=' . $digest;
        $result = json_decode(\Http::get(config('union.req_url') . self::LOWER_LEVEL_AREA_URI.'/'.$id.$str),true);
        return $result;
    }
}