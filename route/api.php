<?php
use \think\facade\Route;
//Token
Route::rule('api/token/user', 'api/Token/getToken')->allowCrossDomain();
//user
Route::rule('api/user/send_msg', 'api/User/sendMsg')->allowCrossDomain();
Route::rule('api/user/login', 'api/User/login')->allowCrossDomain();


Route::rule('api/message/getListByCategory', 'api/Message/getListByCategory')->allowCrossDomain();
Route::rule('api/message/detail', 'api/Message/detail')->allowCrossDomain();
Route::rule('api/initiation/addInitiation', 'api/Initiation/addInitiation')->allowCrossDomain();
Route::rule('api/suggest/addSuggest', 'api/Suggest/addSuggest')->allowCrossDomain();

// 缘定公会列表
Route::rule('api/activity/list', 'api/Activity/activityList')->allowCrossDomain();
Route::rule('api/activity/detail', 'api/Activity/detail')->allowCrossDomain();
// 缘定公会报名
Route::rule('api/activity/apply', 'api/Activity/apply')->allowCrossDomain();





