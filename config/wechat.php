<?php
return [
    'app_id' => 'wx5d1241857434fc66',
    'app_secret' => 'f310168162588c394ed6d7676fce7fef',
//    'app_id' => 'wx9d1865ea3c06a468',
//    'app_secret' => '72b6ab9ddfff4641e0c9e8a356a6f06d',
    'callback' => config('web_url') . '/api/wechat/getUserData',
    'scope' => 'snsapi_userinfo',           // 获取详细用户信息
];