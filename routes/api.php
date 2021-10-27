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
        Route::post('login', 'LoginController@login'); //授权登录 api/api/login/login

        Route::post('pass_login', 'LoginController@passLogin'); //员工端登录 api/api/login/pass_login
        Route::post('out', 'LoginController@loginOut'); //退出 api/api/login/out
        Route::post('phone', 'LoginController@getUserPhone'); //手机号授权 api/api/login/phone

    });
    
    //首页模块
    Route::prefix('index')->group(function () {
        Route::any('index', 'HomeController@Home'); //首页 api/api/index/index
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



        Route::post('user_shop', 'shopController@userShop'); //我的商铺  api/api/shop/user_shop
        Route::post('add_shop','shopController@addShop');//添加商铺  api/api/shop/add_shop
        Route::post('view_shop_data','shopController@setShopView');//修改商铺回显数据 api/api/shop/view_shop_data
        Route::post('set_shop_data','shopController@setShopData');//修改商铺信息 api/api/shop/set_shop_data
        /**
         * 员工申请商铺
         */
        Route::post('agree','shopController@agree');//同意员工申请 api/api/shop/agree
        Route::post('refuse','shopController@refuse');//拒绝员工申请 api/api/shop/refuse
        Route::post('remove','shopController@remove');//移除员工申请 api/api/shop/remove
    });
    Route::prefix('pay')->group(function () {
        Route::post('pay_list', 'payController@payList'); //缴费列表 api/api/pay/pay_list
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
    Route::prefix('remarks')->group(function () {
        Route::post('index','RemarksController@view');  //我的备注  api/api/remarks/index
        Route::post('add', 'RemarksController@addRemarks'); //添加备注  api/api/remarks/add
        Route::post('set', 'RemarksController@update'); //修改备注  api/api/remarks/set
        Route::post('del', 'RemarksController@delRemarks'); //删除备注  api/api/remarks/del
    });
    Route::prefix('hydropower')->group(function () {
        Route::post('index','HydropowerController@index');  //水电登记表首页  api/api/hydropower/index
        Route::post('add', 'HydropowerController@addTable'); //添加水电表  api/api/hydropower/add
        Route::post('set', 'HydropowerController@set'); //修改内容  api/api/hydropower/set
        Route::post('record', 'HydropowerController@record'); //历史记录  api/api/hydropower/record
        Route::post('del', 'HydropowerController@del'); //软删除  api/api/hydropower/del
    });
});