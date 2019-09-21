<?php
use \think\facade\Route;
//user
Route::rule('api/user/profile', 'api/User/profile')->allowCrossDomain();
Route::rule('api/user/info', 'api/User/info')->allowCrossDomain();


Route::rule('api/message/getListByCategory', 'api/Message/getListByCategory')->allowCrossDomain();
Route::rule('api/message/detail', 'api/Message/detail')->allowCrossDomain();
// 入会接口
Route::group('api/initiation/',function (){
    // 申请入会、完善入会信息、重新申请入会
    Route::rule('addInitiation', 'api/Initiation/addInitiation')->allowCrossDomain();
    // 入会信息详情
    Route::rule('info', 'api/Initiation/info')->allowCrossDomain();
    // 匹配省总信息
    Route::rule('verify', 'api/Initiation/verify')->allowCrossDomain();
    // 名族 文化程度 婚姻状态 就业状态 技术等级 户籍类型对应关系
    Route::rule('dict', 'api/Initiation/dict')->allowCrossDomain();
});

Route::rule('api/suggest/addSuggest', 'api/Suggest/addSuggest')->allowCrossDomain();

Route::rule('api/home/banner', 'api/Home/banner')->allowCrossDomain();

// 缘定公会
Route::group('api/activity/',function (){
    Route::rule('list', 'api/Activity/activityList')->allowCrossDomain();
    Route::rule('detail', 'api/Activity/detail')->allowCrossDomain();
    // 缘定公会报名
    Route::rule('apply', 'api/Activity/apply')->allowCrossDomain();
});


//微信网页授权
Route::rule('api/wechat/login','api/WeChat/login')->allowCrossDomain();
Route::rule('api/wechat/getUserInfo','api/WeChat/getUserInfo')->allowCrossDomain();
Route::rule('api/wechat/getUserData','api/WeChat/getUserData')->allowCrossDomain();