<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Redis;
use app\NewClass\Token\Token as Tokens;//apitoken类-自定义

class ApiAuth
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



        $token=$request->header('token');
        if(empty($token)){
             throw new HttpResponseException(response()->json(['code'=>10,'msg'=>'参数错误！']));
        }

        $Tokens=new Tokens;
        $row=$Tokens->check($token);
        $checkRow = $Tokens->checkLogin($token);
        if($row['code']!=1 &&  $checkRow['code'] != 1){
             throw new HttpResponseException(response()->json(['code'=>10,'msg'=>$row['msg']]));
        }
        unset($Tokens);
        
        //自行判断强制需要的参数
        if(!isset($row['row']['user_id'])||empty($row['row']['user_id'])){
             throw new HttpResponseException(response()->json(['code'=>10,'msg'=>'验证错误！']));
        }

        //赋值到请求请求头里面
        $request->attributes->add($row['row']);

        return $next($request);
    }
}
