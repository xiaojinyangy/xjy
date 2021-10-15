<?php


namespace App\Http\Middleware;


use Illuminate\Support\Facades\Auth;

class heared
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
//        eader('Content-Type: text/html;charset=utf-8');
//        header('Access-Control-Allow-Origin:*');
//        header('Access-Control-Allow-Methods:POST,GET,PUT,OPTIONS,DELETE'); // 允许请求的类型
//        header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
//        header('Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Origin,Access-token,Content-Length,Accept-Encoding,X-Requested-with, Origin,Access-Control-Allow-Methods'); // 设置允
        return $next($request);
    }

}