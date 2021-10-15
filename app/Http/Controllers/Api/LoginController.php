<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ww;
use App\Models\RecordJobModel;
use App\Models\User;
use app\NewClass\Token\Pwds;
use app\NewClass\Token\Token as Tokens;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *登录
     */
    public function login(Request $request)
    {
        $code = $request->input('code'); //用户code
        $user_str = $request->input('user'); //用户信息
        $user_arr = json_decode($user_str, true);
        if (empty($code)) {
            return rjson(0, 'code不能为空!');
        }
        if (empty($user_arr)) {
            return rjson(0, '用户信息不能为空!');
        }
        $apiData = $this->apiData($code);
        $arr = json_decode($apiData, true);
        if (empty($arr['openid']) || empty($arr['session_key'])) {
            return rjson(0, '获取失败!');
        }
        $openid = $arr['openid'];
        // $openid = 'oXoIf5O1mPyarudmyaLiuHRfGXfQ';
        $user_model = new User();
        $user = $user_model->getone(['openid' => $openid]);
        if (empty($user)) {
            $add = [
                'openid' => json_decode($apiData)->openid,//openid
                'regist_time' => time(),//注册时间
                'member_style' => 1,//身份状态:1=>.用户,2=>志愿者
                'nick_name' => $user_arr['nickName'],//用户名
                'sex' => $user_arr['gender'],//性别 0：未知、1：男、2：女
                'headpic' => $user_arr['avatarUrl'],
            ];
            $id = $user_model->add($add);
            $user = $user_model->getone(['id' => $id]);
        }
        $data = $this->setredis($user);
        if ($data) {
            return rjson(1, '登录成功！', $data);
        }
        return rjson(0, '用户不存在！');
    }

    /**
     * @param $code
     * @return bool|string
     * 获取
     */
    public function apiData($code)
    {
        //小程序开发账户
        $app_id = config('glabal.miniapp_id'); //
        $secret = config('glabal.key');
        $URL = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $app_id . "&secret=" . $secret . "&js_code=" . $code . "&grant_type=authorization_code";
        return curl_get($URL);
    }

    /**
     * @param $user
     * @return array
     * 设置redis 保持登录状态
     */
    public function setredis($user)
    {
        if (!empty($user)) {
            $Tokens = new Tokens();
            $token = $Tokens->token($user->toArray());
            if (empty($token)) {
                return [];
                //      return rjson(0, '登录错误！');
            }
            $data = [
                'id' => $user->id,
                'nickname' => $user->nickname,
                'member_style' => $user->member_style,
                'token' => $token,
                'headpic' => $user->headpic,
            ];
            return $data;
        } else {
            return [];
        }
    }

    /**
     * 员工登录
     * @param Request $request
     * @return array
     */
    public function passLogin(Request $request){
        $user_id = $request->get('id');
        $job_number = $request->post('job_number');
        $password = $request->post('pass');
        $model = new RecordJobModel();
       $check_job =  $model->index(['job_number'=>$job_number],2);
       if(empty($check_job)) return rjson(0,'工号不存在');
        $password =  md5(md5($password).config('appConfig.passKey'));
       if($check_job->password !=  $password ) return rjson(0,'密码错误');
       if(isset($check_job->user_id)){
           $model->update(['job_number'=>$job_number],['user_id'=>$user_id]);
       }
       $check =  $this->saveToken($check_job);
       if(empty($check)){
           return rjson(0,'登录失败');
       }
       return rjson(200,'登录成功',['token'=>$check,'user_info'=>['job_number'=>$check_job->job_number]]);
    }

    public function saveToken($userData){
        if(!empty($userData)){
            $Tokens = new Tokens();
            $Pwds = new Pwds('guangzhouzhengjiehuodong');
            $redis = linkRedis(1);
            $userData->ip = $Tokens->get_real_ip();
            $token  = $Pwds->encrypt($userData->toArray());
            $redis->setex($token,60*60*24*7,$userData);
            return $token;
        }else{
            return [];
        }
    }

    public function loginOut(Request $request){
        $Tokens = new Tokens();
        $token=$request->header('token');
        $Tokens->loginout($token);
        return rjson(200,'退出成功');
    }

    public function getUserPhone(Request $request){
        $user_id  = $request->get('id');
        $appid = env('WX_APP_ID');
        $appkey = env('WX_APP_KEY');
        $encryptedData = $request->post("encryptedData");
        $iv = $request->post("iv");
        $code = $request->post("code");
        $weixin = file_get_contents("https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$appkey&js_code=".$code."&grant_type=authorization_code");//通过code换取网页授权session_key
        $jsonCode = json_decode($weixin,true);
        //   $open_id = $jsonCode["openid"];
        $access_token = $jsonCode["session_key"];
        $decode  = new WXBizDataCrypt($appid,$appkey);
        $data = $decode->decryptData($encryptedData,$iv);
        $result = json_decode($data,true);
        $user_phone = $result["purePhoneNumber"];
        $user_model = new User();
        $user_model->edit(['id'=>$user_id],['phone'=>$user_phone]);
        return rjson(200,"授权成功",$result);
    }
}
