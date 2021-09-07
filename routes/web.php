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

    // 文件上传类
    Route::prefix('webuploads')->group(function () {
        Route::any('index', 'WebuploadsController@index');//上传文件 admin/webuploads/index
        Route::any('del_file', 'WebuploadsController@del_file');//删除文件 admin/webuploads/del_file
    });
});
