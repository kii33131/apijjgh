<?php
return [
    'app_id' => 'wx5d1241857434fc66',
    'app_secret' => 'f310168162588c394ed6d7676fce7fef',
    'callback' => config('web_url') . '/api/wechat/saveUserData',
    'scope' => 'snsapi_userinfo',           // 获取详细用户信息
];