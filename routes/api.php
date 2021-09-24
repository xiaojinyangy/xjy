<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//无需验证
Route::namespace('Api')->prefix('api')->middleware('throttle:60,1')->group(function () {
    
    //登录注册模块
    Route::prefix('login')->group(function () {
        Route::post('login', 'LoginController@login'); //登录 api/api/login/login
        Route::post('loginout', 'LoginController@loginout'); //退出登录 api/api/login/loginout
    });
    
    //首页模块
    Route::prefix('index')->group(function () {
        Route::post('index', 'HomeController@Home'); //首页 api/api/index/index
        Route::post('message','HomeController@message');  //消息  api/api/index/message
    });
    //区域和档口
//    Route::prefix('index')->group(function () {
//        Route::post('index', 'HomeController@Home'); //首页 api/api/index/index
//        Route::post('message','HomeController@message');  //消息  api/api/index/message
//    });

    Route::prefix('shop')->group(function () {
        Route::post('area_mouth','JobController@areaMouth');  //区域档口  api/api/shop/area_mouth
        Route::post('job_shop', 'JobController@job_shop'); //员工申请商铺  api/api/shop/job_shop
        Route::post('shop_job', 'shopController@shopJob'); //商铺的缴费人员  api/api/shop/shop_job
        Route::post('user_shop', 'shopController@userShop'); //商铺的缴费人员  api/api/shop/user_shop

    });

});


//需要验证-用户端
Route::namespace('Api')->prefix('api')->middleware('apiauths','throttle:60,1')->group(function () {

    //用户
    Route::prefix('user')->group(function () {
        Route::post('index', 'UserController@index'); //个人中心 api/index/user/index
    });

    Route::prefix('shop')->group(function () {
        Route::post('job_apply', 'JobController@Apply'); //员工申请商铺  api/index/shop/index


        //Route::post('job_shop', 'JobController@job_shop'); //员工申请商铺  api/api/shop/job_shop
    });
    
});