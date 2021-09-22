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
Route::namespace('Index')->prefix('api')->middleware('throttle:60,1')->group(function () {
    
    //登录注册模块
    Route::prefix('login')->group(function () {
        Route::post('login', 'LoginController@login'); //登录 api/index/login/login
        Route::post('loginout', 'LoginController@loginout'); //退出登录 api/index/login/loginout
    });
    
    //首页模块
    Route::prefix('index')->group(function () {
        Route::post('index', 'IndexController@index'); //首页 api/index/index/index
    });

});


//需要验证-用户端
Route::namespace('Index')->prefix('api')->middleware('apiauths','throttle:60,1')->group(function () {

    //用户
    Route::prefix('user')->group(function () {
        Route::post('index', 'UserController@index'); //个人中心 api/index/user/index
    });
    
});