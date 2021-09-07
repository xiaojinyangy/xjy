<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\User as UserModel;//用户模型

class UserController extends Controller
{    
  	//个人中心
    public function index(Request $request)
    {   
        //该参数来自于中间件 只能通过get进行获取
        $user_id=$request->get('user_id');
        $user_phone=$request->get('user_phone');

        $data=[
         'user_id'=>$user_id,
         'user_phone'=>$user_phone,
        ];

        return rjson(1,'ok',$data);
    }

}
