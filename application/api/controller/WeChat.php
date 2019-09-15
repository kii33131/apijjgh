<?php
namespace app\api\controller;

use app\api\service\UserService;
use think\Controller;

class WeChat extends Controller
{

    const GET_AUTH_CODE_URL = "https://open.weixin.qq.com/connect/oauth2/authorize";
    const GET_ACCESS_TOKEN_URL = "https://api.weixin.qq.com/sns/oauth2/access_token";
    const GET_USERINFO_URL = "https://api.weixin.qq.com/sns/userinfo";

    /**
     * 登陆
     */
    public function login()
    {
        header("Location:" . $this->getAuthorizeUrl());
    }

    /**
     * 获取authorize_url
     */
    public function getAuthorizeUrl()
    {
        $state = md5(uniqid(rand(), true));
        $queryarr = array(
            "appid"         => config('wechat.app_id'),
            "redirect_uri"  => config('wechat.callback'),
            "response_type" => "code",
            "scope"         => config('wechat.scope'),
            "state"         => $state,
        );
        request()->isMobile() && $queryarr['display'] = 'mobile';
        $url = self::GET_AUTH_CODE_URL . '?' . http_build_query($queryarr) . '#wechat_redirect';
        return $url;
    }

    /**
     * 获取用户信息
     * @param array $params
     * @return array
     */
    public function getUserInfo($params = [])
    {
        $params = $params ? $params : $_GET;
        if (isset($params['code'])) {
            //获取access_token
            $data = isset($params['code']) ? $this->getAccessToken($params['code']) : $params;
            $access_token = isset($data['access_token']) ? $data['access_token'] : '';
            $refresh_token = isset($data['refresh_token']) ? $data['refresh_token'] : '';
            $expires_in = isset($data['expires_in']) ? $data['expires_in'] : 0;
            if ($access_token) {
                $openid = isset($data['openid']) ? $data['openid'] : '';
                $unionid = isset($data['unionid']) ? $data['unionid'] : '';
                if (stripos(config('wechat.scope'), 'snsapi_userinfo') !== false) {
                    //获取用户信息
                    $queryarr = [
                        "access_token" => $access_token,
                        "openid"       => $openid,
                        "lang"         => 'zh_CN'
                    ];
                    $ret = \Http::post(self::GET_USERINFO_URL, $queryarr);
                    $userinfo = json_decode($ret, true);
                    if (!$userinfo || isset($userinfo['errcode'])) {
                        return [];
                    }
                    $userinfo = $userinfo ? $userinfo : [];
                    $userinfo['avatar'] = isset($userinfo['headimgurl']) ? $userinfo['headimgurl'] : '';
                } else {
                    $userinfo = [];
                }
                $data = [
                    'access_token'  => $access_token,
                    'refresh_token' => $refresh_token,
                    'expires_in'    => $expires_in,
                    'openid'        => $openid,
                    'unionid'       => $unionid,
                    'userinfo'      => $userinfo
                ];
                return $data;
            }
        }
        return [];
    }

    public function saveUserData()
    {
        $code = $this->request->request("code");
        //通过code换access_token和绑定会员
        $result = $this->getUserInfo(['code' => $code]);
        if ($result) {
            $loginret = UserService::connect($result);
            if ($loginret) {
                $data = [
                    'userinfo'  => $loginret,
                    'thirdinfo' => $result
                ];
                success($data);
            }
        }
        error('参数错误',500);
    }

    /**
     * 获取access_token
     * @param string code
     * @return array
     */
    private function getAccessToken($code = '')
    {
        if (!$code) {
            return '';
        }
        $queryarr = array(
            "appid"      => config('wechat.app_id'),
            "secret"     => config('wechat.app_secret'),
            "code"       => $code,
            "grant_type" => "authorization_code",
        );
        $response = \Http::post(self::GET_ACCESS_TOKEN_URL, $queryarr);
        $ret = json_decode($response, true);
        return $ret ? $ret : [];
    }
}
