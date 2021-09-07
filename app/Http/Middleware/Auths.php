<?php

namespace App\Http\Middleware;

use Closure;
use App\NewClass\Auth\Auth as AuthModel;//后台权限认证类

class Auths
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
    */
    public function handle($request, Closure $next)
    {   
        //验证是否登录
        if (!($request->session()->has('admin_id')) || !($request->session()->has('admin_name'))) {
           return redirect('admin/login/logout');
        }
        
        $admin_id=$request->session()->get('admin_id');
        //检查权限操作
        $AuthModel=new AuthModel;
        //被检查路由
        $rule_name=str_replace('.html','/',ltrim($_SERVER["REQUEST_URI"],'/'));
        $rule_name=str_replace('?','/',$rule_name);
        $rule_name=explode('/', $rule_name);
        if(count($rule_name)<3){
           return redirect('admin/index/index');
        }
        $rule_name=$rule_name[0].'/'.$rule_name[1].'/'.$rule_name[2];//格式 index/user/index
        
        $result=$AuthModel->check($rule_name,$admin_id);
        if(!$result){
            showmsg('没有权限！',0);
            return redirect('admin/index/indexv1');
        }

        return $next($request);
    }
}
