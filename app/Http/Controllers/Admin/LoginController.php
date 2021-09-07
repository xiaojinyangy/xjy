<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin as AdminModel;//管理员模型
use App\Models\Config as ConfigModel;//配置模型
use App\Http\Requests\admin\Login as LoginRequest;//登录验证表单

class LoginController extends Controller
{
     public function index()
     {  
        $ConfigModel=new ConfigModel;
        $config=$ConfigModel->getone(['config_id'=>1],['config_title','config_keywords','config_desc']);
        $data=[
           'config'=>$config
        ];
        return view('admin.login.index',$data);
     }

     public function login(LoginRequest $request)
     {  
         $data= $request->validated();
         $where=[
            'admin_name'=>$data['admin_name'],
         ];
         $AdminModel=new AdminModel;
         $admin=$AdminModel->getone($where,['admin_id','admin_name','admin_pwd','admin_show','admin_ip','admin_time']);
         if(empty($admin)){
              return rjson(0,'账户不存在！');
         }elseif(!(Hash::check($data['admin_pwd'], $admin->admin_pwd))){
              return rjson(0,'密码错误！');
         }elseif($admin->admin_show !=1 ){
              return rjson(0,'禁止登录！');
         }

         $log_data=[
	           'admin_ip'=>getIP(),
	           'admin_time'=>date('Y-m-d H:i:s',time()),
	           'admin_last_ip'=>$admin->admin_ip,
	           'admin_last_time'=>$admin->admin_time,
         ];
         $AdminModel->edit(['admin_id'=>$admin->admin_id],$log_data);

         session(['admin_id' => $admin->admin_id]);
         session(['admin_name' => $admin->admin_name]);

         return rjson(1,'登录成功');
     }

     public function logout(Request $request)
	 {   
		$request->session()->forget(['admin_id', 'admin_name']);
        return redirect('admin/login/index');
	 }
}
