<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\NewClass\Webuploads\Webuploads as WebuploadsModel;//百度上传文件类 自定义

class WebuploadsController extends Controller
{    
	  //上传文件
    public function index(Request $request)
    {    
        $WebuploadsModel=new WebuploadsModel;
        $file=$WebuploadsModel->upload($request);
        return $file;
    }
    
    //删除文件
    public function del_file(Request $request)
    {   
        $data=$request->all();
        if(empty($data['file_path'])){
           return ['code'=>0,'msg'=>'路径为空'];
        }
        $WebuploadsModel=new WebuploadsModel;
        $row=$WebuploadsModel->del_file($data['file_path']);
        if($row){
           return ['code'=>1,'msg'=>'删除成功！'];
        }else{
           return ['code'=>0,'msg'=>'删除失败！'];
        }
    }
}
