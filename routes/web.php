<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*Admin 无权限认证*/
Route::namespace('Admin')->prefix('admin')->group(function () {

	// 登录模块
    Route::prefix('login')->group(function () {
        Route::get('index', 'LoginController@index');
        Route::post('login', 'LoginController@login');
        Route::get('logout', 'LoginController@logout');
    });

});

/*admin 有权限认证*/
Route::namespace('Admin')->prefix('admin')->middleware('auths')->group(function () {

    // 首页模块
    Route::prefix('index')->group(function () {
        Route::get('index', 'IndexController@index');//菜单栏目 admin/index/index
        Route::get('indexv1', 'IndexController@indexv1');//首页 admin/index/indexv1
        Route::get('editpass', 'IndexController@editpass');//修改密码 admin/index/editpass
        Route::post('posteditpass', 'IndexController@posteditpass');//修改密码提交 admin/index/posteditpass
    });

    // 菜单模块
    Route::prefix('nav')->group(function () {
        Route::get('index', 'NavController@index');//菜单列表 admin/nav/index
        Route::get('add', 'NavController@add');//菜单添加 admin/nav/add
        Route::post('postadd', 'NavController@postadd');//菜单添加-提交 admin/nav/postadd
        Route::get('edit/{id}', 'NavController@edit');//菜单编辑 admin/nav/edit
        Route::post('postedit/{id}', 'NavController@postedit');//菜单编辑-提交 admin/nav/postedit
        Route::get('del/{id}', 'NavController@del');//菜单删除 admin/nav/del
    });

    // 权限模块
    Route::prefix('authrule')->group(function () {
        Route::get('index', 'AuthRuleController@index');//权限列表 admin/authrule/index
        Route::get('add', 'AuthRuleController@add');//权限添加 admin/authrule/add
        Route::post('postadd', 'AuthRuleController@postadd');//权限添加-提交 admin/authrule/postadd
        Route::get('edit/{id}', 'AuthRuleController@edit');//权限编辑 admin/authrule/edit
        Route::post('postedit/{id}', 'AuthRuleController@postedit');//权限编辑-提交 admin/authrule/postedit
        Route::get('del/{id}', 'AuthRuleController@del');//权限删除 admin/authrule/del
        Route::post('ban/{id}', 'AuthRuleController@ban');//权限禁用 admin/authrule/ban
        Route::post('cancelban/{id}', 'AuthRuleController@cancelban');//权限启用 admin/authrule/cancelban
    });

    // 后台管理组模块
    Route::prefix('authgroup')->group(function () {
        Route::match(['get','post'],'index', 'AuthGroupController@index');//后台管理组列表 admin/authgroup/index
        Route::get('add', 'AuthGroupController@add');//后台管理组添加 admin/authgroup/add
        Route::post('postadd', 'AuthGroupController@postadd');//后台管理组添加-提交 admin/authgroup/postadd
        Route::get('edit/{id}', 'AuthGroupController@edit');//后台管理组编辑 admin/authgroup/edit
        Route::post('postedit/{id}', 'AuthGroupController@postedit');//后台管理组编辑-提交 admin/authgroup/postedit
        Route::get('del/{id}', 'AuthGroupController@del');//后台管理组删除 admin/authgroup/del
        Route::post('ban/{id}', 'AuthGroupController@ban');//后台管理组禁用 admin/authgroup/ban
        Route::post('cancelban/{id}', 'AuthGroupController@cancelban');//后台管理组启用 admin/authgroup/cancelban
        Route::get('allocate/{id}', 'AuthGroupController@allocate');//权限分配 admin/authgroup/allocate
        Route::post('postallocate/{id}', 'AuthGroupController@postallocate');//权限分配-提交 admin/authgroup/postallocate
    });

    // 管理组与管理员关系模块
    Route::prefix('authgroupaccesses')->group(function () {
        Route::match(['get','post'],'index/{id}', 'AuthGroupAccessesController@index');//管理组与管理员关系列表 admin/authgroupaccesses/index
        Route::get('add/{id}', 'AuthGroupAccessesController@add');//管理组与管理员关系添加 admin/authgroupaccesses/add
        Route::post('postadd/{id}', 'AuthGroupAccessesController@postadd');//管理组与管理员关系添加-提交 admin/authgroupaccesses/postadd
        Route::get('del/{id}', 'AuthGroupAccessesController@del');//管理组与管理员关系删除 admin/authgroupaccesses/del
    });

    // 管理员模块
    Route::prefix('admin')->group(function () {
        Route::match(['get','post'],'index', 'AdminController@index');//管理员列表 admin/admin/index
        Route::get('add', 'AdminController@add');//管理员添加 admin/admin/add
        Route::post('postadd', 'AdminController@postadd');//管理员添加-提交 admin/admin/postadd
        Route::get('edit/{id}', 'AdminController@edit');//管理员编辑 admin/admin/edit
        Route::post('postedit/{id}', 'AdminController@postedit');//管理员编辑-提交 admin/admin/postedit
        Route::get('del/{id}', 'AdminController@del');//管理员删除 admin/admin/del
        Route::post('ban/{id}', 'AdminController@ban');//管理员禁用 admin/admin/ban
        Route::post('cancelban/{id}', 'AdminController@cancelban');//管理员启用 admin/admin/cancelban
    });

    // 系统配置模块
    Route::prefix('config')->group(function () {
        Route::get('edit', 'ConfigController@edit');//系统配置编辑 admin/config/edit
        Route::post('postedit', 'ConfigController@postedit');//系统配置编辑-提交 admin/config/postedit
    });
    /**
     * 会员
     */
    Route::prefix('users')->group(function (){
        Route::any('index', 'usersController@index');//用户列表 admin/users/index
        Route::any('info', 'usersController@Info');//用户详细 admin/users/info
        Route::post('del', 'usersController@del');//删除 admin/users/del
        Route::any('user_shop', 'userShopController@getUserShop');//用户的店铺 admin/users/user_shop
    });
    /**
     * 员工
     */
    Route::prefix('job')->group(function (){
        Route::any('index', 'JobController@index');//员工列表 admin/job/index
        Route::any('add', 'JobController@add');//员工添加 admin/job/add
        Route::any('set', 'JobController@set');//员工编辑 admin/job/set
        Route::post('del', 'JobController@del');//员工删除 admin/job/del
    });
    /**
     * 商铺
     */
    Route::prefix('shop')->group(function (){
        Route::any('index', 'UserShopController@index');//商铺列表 admin/shop/index
     //   Route::any('add', 'UserShopController@add');//用户详细 admin/shop/add
        Route::any('set', 'UserShopController@set');//商铺修改 admin/shop/set
        Route::post('del', 'UserShopController@del');//商铺删除 admin/shop/del
    });

    /**
     * 区域 管理
     */
    Route::prefix('area')->group(function (){
        Route::any('index', 'AreaController@index');//区域列表 admin/area/index
        Route::any('set', 'AreaController@set');//区域修改显示/提交 admin/area/set
        Route::any('add', 'AreaController@add');//区域添加显示/提交 admin/area/add
        Route::post('del', 'AreaController@del');//区域删除 admin/area/index
    });
    /**
     * 基础设置
     */
    Route::prefix('basics')->group(function (){
        Route::any('index', 'BasicsController@index');//费用编辑(提交/页面)列表 admin/area/index
        Route::any('list', 'BasicsController@list');//费用列表  admin/basics/list
        Route::any('add', 'BasicsController@add');//费用添加  admin/basics/add
        Route::any('rant_ext', 'BasicsController@rant_ext');//附加费(显示和编辑) admin/basics/rant_ext
        Route::post('del', 'BasicsController@del');//费用删除 admin/basics/del
        Route::post('ext_del', 'BasicsController@ext_del');//区域删除 admin/basics/ext_del

    });
    /**
     * 档口管理
     */
    Route::prefix('shop_mouth')->group(function (){
        Route::any('index', 'shopMouthController@index');//档口列表 admin/shop_mouth/index
        Route::any('set', 'shopMouthController@set');//档口修改显示/提交 admin/shop_mouth/set
        Route::any('add', 'shopMouthController@add');//档口添加显示/提交 admin/shop_mouth/add
        Route::post('del', 'shopMouthController@del');//档口删除 admin/shop_mouth/del
        Route::get('area_mouth', 'shopMouthController@area_mouth');//档口删除 admin/shop_mouth/area_mouth
    });
    /**
     * 轮播图
     */
    Route::prefix('image')->group(function (){
        Route::any('index', 'ImageController@index');//轮播图 admin/image/index
        Route::any('add', 'ImageController@add');//添加轮播图 admin/image/add
        Route::any('set', 'ImageController@set');//修改轮播图 admin/image/set
        Route::post('del', 'ImageController@del');//删除轮播图 admin/image/del
    });
    /**
     * 首页设置
     */
    Route::prefix('system')->group(function (){
        Route::any('text', 'SetupController@imageText');//图文介绍编辑 admin/system/text
        Route::any('phone', 'SetupController@setPhone');//联系电话编辑 admin/system/phone
    });

    /**
     * 消息
     */
    Route::prefix('message')->group(function (){
        Route::any('index', 'MessageController@index');//消息列表 admin/message/index
        Route::any('add', 'MessageController@add');//消息添加  admin/message/add
        Route::any('set', 'MessageController@set');//消息修改  admin/message/set
        Route::post('del', 'MessageController@del');//消息删除  admin/message/del
    });

    /**
     * 水电费列表
     */
    Route::prefix('hydropower')->group(function (){
        Route::any('index', 'HydropowerController@index');//图文介绍编辑 admin/hydropower/index
        Route::any('phone', 'HydropowerController@setPhone');//联系电话编辑 admin/hydropower/phone
    });
    // 文件上传类
    Route::prefix('webuploads')->group(function () {
        Route::any('index', 'WebuploadsController@index');//上传文件 admin/webuploads/index
        Route::any('del_file', 'WebuploadsController@del_file');//删除文件 admin/webuploads/del_file
    });
});
