<?php 
namespace app\NewClass\Token;

use Illuminate\Support\Facades\Redis;
use app\NewClass\Token\Pwds;//加密解密 类库
/*
   使用要求 
   1.开启 openssl
   2.引入 pwds 加密解密 类库
   使用方式 
       $Token=new Token;
       $user=[
           'user'=>1,
       ];
       //生成token
       $token=$Token->token($user);
       //验证token
       $row=$Token->check($token);  
       //退出token
       $row=$Token->loginout($token);  
*/

class Token{  

  	private $Pwds;

  	public function __construct()
  	{      
           date_default_timezone_set("PRC");
           $this->Pwds=new Pwds('guangzhouzhengjiehuodong');
  	}

  	//获取客户端真实ip
  	private function get_real_ip()
  	{
  	    $ip=false;
  	    //客户端IP 或 NONE 
  	    if(!empty($_SERVER["HTTP_CLIENT_IP"])){
  	        $ip = $_SERVER["HTTP_CLIENT_IP"];
  	    }
  	    //多重代理服务器下的客户端真实IP地址（可能伪造）,如果没有使用代理，此字段为空
  	    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
  	        $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
  	        if ($ip) { array_unshift($ips, $ip); $ip = false; }
  	        for ($i = 0; $i < count($ips); $i++) {
  	            if (!preg_match("/^(10│172.16│192.168)./", $ips[$i])) {
  	                $ip = $ips[$i];
  	                break;
  	            }
  	        }
  	    }
  	    //客户端IP 或 (最后一个)代理服务器 IP 
  	    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
  	}
    
    /*//生成token 并存储 到 缓存里面 并设置 过期时间
      $data 数组
      $time 设置过期时间 默认 7天
      结果 返回  token 字符串
    */
    public function token($data,$time=604800)
    {
         if(is_array($data)){
            $data['ip']=$this->get_real_ip();//获取客户端的ip
            $token=$this->Pwds->encrypt($data);//生成token
            //把数据存进缓存 并设置 过期时间
            Redis::setex($token,$time,json_encode($data));
            return $token;
         }else{
         	  return false;
         }
    }
    
    //验证token 是否正确 是否 过期
    public function check($token)
    {
        if(empty($token)){
            return ['code'=>0,'msg'=>'参数不能为空！'];
        }
        $cache=Redis::get($token);
        if($cache){
            //判断 token 是否可以解密
            $row=$this->Pwds->decrypt($token);//token解密
            if(empty($row)){
               Redis::del($token);
               return ['code'=>2,'msg'=>'数据错误！'];
            }

            $row=json_decode($row,true);
            if(empty($row)){
               return ['code'=>3,'msg'=>'数据错误！！'];
            }
            
            //获取缓存的剩余时间
            $time=Redis::ttl($token);
            if($time<=86400){//当剩余有效时间小于86400秒的时候
                Redis::expire($token,604800);//延长有效时间
            }
            return ['code'=>1,'msg'=>'ok！','row'=>$row];
        }else{
            //token不存在
        	  return ['code'=>4,'msg'=>'登录过期！'];
        }
    }
    
    //退出 删除token
    public function loginout($token)
    {
        $row=Redis::del($token);
        return $row;
    }
}

