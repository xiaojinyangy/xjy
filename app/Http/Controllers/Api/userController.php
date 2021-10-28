<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Http\Request;

class userController extends Controller
{


    public function getUserInfo(Request $request){
        $user_id = $request->get('user_id');
    
        $userModel =  new \App\Models\User();
       $userData =  $userModel->query()->select(['nick_name','phone','identity','headpic'])->find($user_id);
       if(!empty($userData)){
           return rjson(200,'请求成功',[
               'nick_name' =>$userData->nick_name,
                'phone' =>isset($userData->phone) ? $userData->phone : "",
                'identity' =>$userData->identity,
                'headpic' =>$userData->headpic
            ]);
       }
       return rjson(0,'用户不存在');
    }

}