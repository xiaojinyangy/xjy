<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use app\NewClass\Token\Token as Tokens;//apitoken类-自定义
use App\Models\User as UserModel;//用户模型
use App\Http\Requests\index\Login as LoginRequest;//登录验证表单

class LoginController extends Controller
{    
    //登录
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $UserModel=new UserModel;
        //查询用户
        $field=['user_id','user_name','user_phone'];
        $user=$UserModel->getone(['user_phone'=>$data['user_phone']],$field);
        if(!empty($user)){
            $Tokens=new Tokens;
            $token=$Tokens->token($user->toArray());
            if(empty($token)){
              return rjson(0,'登录错误！');
            }
            $user->token=$token;

            $data=[
               'user'=>$user,
            ];

            return rjson(1,'登录成功！',$data);
        }else{
            return rjson(0,'用户不存在！');
        }
    }

    //退出登录
    public function loginout(Request $request)
    {
        $token=$request->header('token');

        $Tokens=new Tokens;
        $row=$Tokens->loginout($token);

        $data=[
           'row'=>$row,
        ];

        return rjson(1,'退出登录成功！',$data);
    }
}
