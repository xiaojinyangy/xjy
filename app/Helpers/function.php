<?php 

use App\NewClass\Auth\Auth as AuthModel;//后台权限认证类

if (!function_exists('rjson')) {
    //返回数据处理
	function rjson($code,$msg,$data=[])
	{
		$arr=[
	       'code'=>$code,
	       'msg'=>$msg,
	       'data'=>$data,
		];
		return $arr;
	}
}

if (!function_exists('getIP')) {
    //客户端IP，
	function getIP(){   
	    $ip=FALSE;
	    //客户端IP 或 NONE 
	    if(!empty($_SERVER["HTTP_CLIENT_IP"])){
	        $ip = $_SERVER["HTTP_CLIENT_IP"];
	    }
	    //多重代理服务器下的客户端真实IP地址（可能伪造）,如果没有使用代理，此字段为空
	    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	        $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
	        if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
	        for ($i = 0; $i < count($ips); $i++) {
	            if (!preg_match ("/^(10│172.16│192.168)./", $ips[$i])) {
	                $ip = $ips[$i];
	                break;
	            }
	        }
	    }
	    //客户端IP 或 (最后一个)代理服务器 IP 
	    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
	}
}

if (!function_exists('showmsg')) {
    //弹窗提示 1.OK 2.OK 3.一般 4.警告 5.错误
    //采用了Laravel内置的Illuminate\Session\Store中的一次性请求flash函数
	function showmsg($msg,$status=1)
	{   
		if($status==1){
			$row=myflash($msg);
		}elseif($status==2){
			$row=myflash()->success($msg);
		}elseif ($status==3) {
			$row=myflash()->info($msg);
		}elseif ($status==4) {
			$row=myflash()->warning($msg);
		}else{
			$row=myflash()->error($msg);
		}
		return $row;
	}
}

if (!function_exists('authchecks')) {
    //检测按钮权限
	function authchecks($rule_name)
	{   
		$admin_id=session('admin_id');
		$AuthModel=new AuthModel;
		$result=$AuthModel->check($rule_name,$admin_id);
		return $result;
	}
}











?>