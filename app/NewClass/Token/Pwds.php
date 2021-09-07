<?php 
namespace app\NewClass\Token;

/*
   使用要求 开启 openssl
    使用方法
    // $user=[
    //    'user_id'=>1,//用户id
    //    'time'=>time(),//过期时间
    //    'number'=>rand_str(5)//随机数五位
    // ];
	// $user='按时大叔大婶大阿萨德按时';
    $pwds=new Pwds('你设置的密码');
    $encrypted_string=$pwds->encrypt($user);
    $decrypted_string=$pwds->decrypt($encrypted_string);
 */

class Pwds{  
    
    private $password;

	public function __construct($password)
	{
         $this->password=$password;
	}
   
    private function sign($message, $key) 
    {
      return hash_hmac('sha256', $message, $key) . $message;
	}

	private function verify($bundle, $key) 
	{
	    return hash_equals(
	      hash_hmac('sha256', mb_substr($bundle, 64, null, '8bit'), $key),
	      mb_substr($bundle, 0, 64, '8bit')
	    );
	}

	private function getKey($password, $keysize = 16) 
	{
	    return hash_pbkdf2('sha256',$password,'some_token',100000,$keysize,true);
	}

	/**
	 * 将数组转化成字符串
	*/
	private function arr_str($message) 
	{
		if(is_array($message)){
            $str=json_encode($message);
            return $str;
		}else{
			return false;
		}
	}
    
    //加密 
	public function encrypt($message) 
	{
		if(is_array($message)){//
            $message=$this->arr_str($message);
            return $this->encrypt($message);
		}elseif(is_string($message)){//判断是不是字符串
            $iv = random_bytes(16);
		    $key =$this->getKey($this->password);
		    $result = $this->sign(openssl_encrypt($message,'aes-256-ctr',$key,OPENSSL_RAW_DATA,$iv), $key);
		    return bin2hex($iv).bin2hex($result);
		}else{
			return false;
		}
	}
    
    //解密  返回的是解密后的字符串
	public function decrypt($hash) 
	{
	    $iv = hex2bin(substr($hash, 0, 32));
	    $data = hex2bin(substr($hash, 32));
	    $key = $this->getKey($this->password);
	    if (!$this->verify($data, $key)) {
	      return null;
	    }
	    return openssl_decrypt(mb_substr($data, 64, null, '8bit'),'aes-256-ctr',$key,OPENSSL_RAW_DATA,$iv);
	}
   
}

