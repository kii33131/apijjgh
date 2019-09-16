<?php
use \think\facade\Route;
//user
Route::rule('api/user/profile', 'api/User/profile')->allowCrossDomain();
Route::rule('api/user/info', 'api/User/info')->allowCrossDomain();


Route::rule('api/message/getListByCategory', 'api/Message/getListByCategory')->allowCrossDomain();
Route::rule('api/message/detail', 'api/Message/detail')->allowCrossDomain();
Route::rule('api/initiation/addInitiation', 'api/Initiation/addInitiation')->allowCrossDomain();
Route::rule('api/suggest/addSuggest', 'api/Suggest/addSuggest')->allowCrossDomain();

Route::rule('api/home/banner', 'api/Home/banner')->allowCrossDomain();

// 缘定公会列表
Route::rule('api/activity/list', 'api/Activity/activityList')->allowCrossDomain();
Route::rule('api/activity/detail', 'api/Activity/detail')->allowCrossDomain();
// 缘定公会报名
Route::rule('api/activity/apply', 'api/Activity/apply')->allowCrossDomain();

//微信网页授权
Route::rule('api/wechat/login','api/WeChat/login')->allowCrossDomain();
Route::rule('api/wechat/getUserInfo','api/WeChat/getUserInfo')->allowCrossDomain();
Route::rule('api/wechat/getUserData','api/WeChat/getUserData')->allowCrossDomain();