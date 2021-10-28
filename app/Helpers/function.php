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
if(!function_exists('Ajax_Arr')){
    //接收 ajax serializeArray 数据 处理
    function Ajax_Arr(Array $array){
        if(is_array($array)){
            $Array  = [];
            foreach($array as $key=>$value){
                if(!empty($value["value"])){
                    $Array = array_merge($Array,[$value['name']=>$value["value"]]);
                }
            }
            return $Array;
        }
    }
}

/**
 * 返回api分页结果集
 * @param $results
 * @return array
 */
if (!function_exists('getPaginateData')) {
    function getPaginateData($results)
    {
        return [
            'perPage' => $results->perPage(), // 每页的数据条数
            'currentPage' => $results->currentPage(), // 获取当前页页码
            'lastPage' => $results->lastPage(), // 获取最后一页的页码
            'data' => $results->items(),// 获取当前页的所有项
            'total' => $results->total()
        ];
    }
}

/**
 * 搜索数组处理
 * array()
 */
if(!function_exists('searchArray')){
    function searchArray($request,$array){
        $where = [];
        $search = [];
        $timeArr = [];//定义时间字段数组
        foreach($array as $key =>$sybol){
            $value = $request->input($key);
            if(!isset($value) || empty($value)){
                continue;
            }
            $search[$key]  = $value;
            $where[] = [$key,$sybol,$value];
        }
        return [$where,$search];
    }
}

if(!function_exists('searchArray')){
    function make_tree($list,$pk='id',$pid='pid',$child='child',$root=0){
        $tree=array();
        $packData=array();
        foreach ($list as $data) {
            $packData[$data[$pk]] = $data;
        }
        foreach ($packData as $key =>$val){
            if($val[$pid]==$root){//代表跟节点
                $tree[]=& $packData[$key];
            }else{
                //找到其父类
                $packData[$val[$pid]][$child][]=&$packData[$key];
            }
        }
        return $tree;
    }
}

if(!function_exists('linkRedis')){
    function linkRedis($db,$password=""){
        $redis = new \Redis();
        $redis->connect(env('REDIS_HOST'),env('REDIS_PORT'));
        if(!empty($password)){
            $redis->auth(env('REDIS_PASSWORD'));
        }
       $redis->select($db);
        return $redis;
    }
}
if(!function_exists('fullTextImage')){
    function fullTextImage($content){
        $regular = '/<img.*?src=\"(.*?)\".*?\/?>/i';
        preg_match_all($regular,trim($content),$pmch);
        unset($pmch[0]);
        for($i=0;$i<=count($pmch[1]);$i++){
            if(isset($pmch[1][$i])){
                $str =   "<img style:'max-width:100%;margin:0 auto;' class='content_img'";
                $content =  str_replace("<img ",$str,$content);
                $content =   str_replace($pmch[1][$i],config('appConfig.url_http').$pmch[1][$i],$content);
            }
        }
        return $content;
    }
}









?>