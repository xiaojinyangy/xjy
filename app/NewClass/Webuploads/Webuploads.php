<?php 
namespace app\NewClass\Webuploads;

use App\Models\UpImageModel;

class Webuploads
{   
    
    //字符串转码
    public function unicode2utf8($str)
    {
	  if(!$str) return $str;
	  $decode = json_decode($str);
	  if($decode) return $decode;
	  $str = '["' . $str . '"]';
	  $decode = json_decode($str);
	  if(count($decode) == 1){
	  return $decode[0];
	  }
	  return $str;
	}
    
    //絕對路徑
	public function dirs()
	{
         $dir=__DIR__;
         $index=stripos($dir,'app');
         $str=substr($dir,0,$index);
         return $str;
	}
    
    //把绝对路径变成相对路径 
	public function filepath($filepath)
	{
         $index=stripos($filepath,DIRECTORY_SEPARATOR.'uploads');
         $str=substr($filepath,$index);
         return $str;
	}
    
    //上傳文件
	public function upload($request,$paths='')
	{
	      header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		  header("Cache-Control: no-store, no-cache, must-revalidate");
		  header("Cache-Control: post-check=0, pre-check=0", false);
		  header("Pragma: no-cache");
  
		  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
		      exit; // finish preflight CORS requests here
		  }
		  if ( !empty($_REQUEST[ 'debug' ]) ) {
			   $random = rand(0, intval($_REQUEST[ 'debug' ]) );
			   if ( $random === 0 ) {
				    header("HTTP/1.0 500 Internal Server Error");
				    exit;
			   }
		  }
		  @set_time_limit(5 * 60);
		 
		  $targetDir = $this->dirs().'public'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'file_material_tmp';//临时文件夹
		  //文件存放地址
		  if(!empty($paths)){
            $uploadDir = $this->dirs().'public'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$paths.DIRECTORY_SEPARATOR.date('Ymd').DIRECTORY_SEPARATOR.date('H');
		  }else{
			$uploadDir = $this->dirs().'public'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'file_material'.DIRECTORY_SEPARATOR.date('Ymd').DIRECTORY_SEPARATOR.date('His');
		  }

		  $cleanupTargetDir = true; // Remove old files
		  $maxFileAge = 5 * 3600; // Temp file age in seconds
		  
		  if (!file_exists($targetDir)) {
		    @mkdir($targetDir,0777,true);
		  }
		  
		  if (!file_exists($uploadDir)) {
		    @mkdir($uploadDir,0777,true);
		  }
		  
		  if (isset($_REQUEST["name"])) {
		   $fileName = $_REQUEST["name"];
		  } elseif (!empty($_FILES)) {
		   $fileName = $_FILES["file"]["name"];
		  } else {
		   $fileName = uniqid("file_");
		  }
		  //-------------------------------------------------------
		    $fileName=$this->unicode2utf8('"'.$fileName.'"');
		    $fileName= iconv("UTF-8", "GBK", $fileName);//防止fopen语句失效
		  //-----------------------------------------------------------------------
		  $oldName = $fileName;
		  $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
		 
		  $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		  $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;
		  // Remove old temp files
		  
		  if ($cleanupTargetDir) {
			   if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
			      die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
			   }
			   while (($file = readdir($dir)) !== false) {
				    $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
				  
				    if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
				     continue;
				    }
				    
				    if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
				     @unlink($tmpfilePath);
				    }
			   }
			   closedir($dir);
		  }
		  // Open temp file
		  if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
		      die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		  }
		  if (!empty($_FILES)) {
			   if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
			    die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
			   }
			   // Read binary input stream and append it to temp file
			   if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
			    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			   }
		  } else {
			   if (!$in = @fopen("php://input", "rb")) {
			    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			   }
		  }
		  while ($buff = fread($in, 4096)) {
		       fwrite($out, $buff);
		  }
		  @fclose($out);
		  @fclose($in);
		  rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");
		  $index = 0;
		  $done = true;
		  for( $index = 0; $index < $chunks; $index++ ) {
			   if ( !file_exists("{$filePath}_{$index}.part") ) {
			    $done = false;
			    break;
			   }
		  }
		  
		  if ( $done ) {
			   $pathInfo = pathinfo($fileName);//文件后缀
			   $hashStr = substr(md5($pathInfo['basename']),8,16);//
			   $hashName = time() . $hashStr . '.' .$pathInfo['extension'];
			   $uploadPath = $uploadDir . DIRECTORY_SEPARATOR .$hashName;
			  
			   if (!$out = @fopen($uploadPath, "wb")) {
			    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			   }
		       if ( flock($out, LOCK_EX) ) {
				    for( $index = 0; $index < $chunks; $index++ ) {
					     if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
					      break;
					     }
					     while ($buff = fread($in, 4096)) {
					      fwrite($out, $buff);
					     }
					     @fclose($in);
				         @unlink("{$filePath}_{$index}.part");
				    }
				    flock($out, LOCK_UN);
			   }
			   @fclose($out);
			   // $response = [
				  //   'success'=>true,
				  //   'oldName'=>$oldName,//原文件名
				  //   'filePaht'=>$uploadPath,//文件路径  绝对路径
				  //   'fileSuffixes'=>$pathInfo['extension'],//文件后缀
			   // ];
			   $data = [
			       'file_size' =>$_FILES['file']['size'],
                   'filename'  => $pathInfo['basename'],
                   'file_path' => $this->filepath($uploadPath),
                   'suffix'=> $pathInfo['extension'],
                   'created_at' => date('Y-m-d H:i:s')
               ];
			   $model = new UpImageModel();
                $id = $model->query()->insertGetId($data);
			   $response = [
			       'id' => $id,
				    'filePaht'=>$this->filepath($uploadPath),//文件路径  相对路径
			   ];
			   return json_encode($response);
		  }
		  
		  // Return Success JSON-RPC response
		  $response = [
		  ];
		  return json_encode($response);
	}
    
    //刪除文件
    public function del_file($file_path)
    {
        //先做個文件是否存在判斷
        $path=$this->dirs().'public/'.$file_path;
        if(file_exists($path)){
        	 //存在就刪除
            $row=@unlink($path);
            return $row;
        }else{
           //不存在就返回 true
           return true;
        }
    }
}