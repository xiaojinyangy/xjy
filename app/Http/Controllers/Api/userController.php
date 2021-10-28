<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class userController extends Controller
{


    public function getUserInfo(Request $request){
        $user_id = $request->get('id');
        $userModel = new User();
       $userData =  $userModel->query()->select(['nick_name','phone','identity','identity'])->find($user_id);
       if(!empty($userData)){
           return rjson(0,'请求成功',$userData->toArray());
       }
       return rjson(0,'用户不存在');
    }

}