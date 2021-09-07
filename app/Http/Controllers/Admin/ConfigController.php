<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Models\Config as ConfigModel;//系统配置模型
use App\Http\Requests\admin\Config as ConfigRequest;//系统配置验证表单

class ConfigController extends Controller
{    
    //编辑
    public function edit()
    {   
        $ConfigModel=new ConfigModel;
        $config=$ConfigModel->getone(['config_id'=>1],[]);
        $data=[
          'config'=>$config,
        ];
        return view('admin.config.edit',$data);
    }
    
    //编辑-提交
    public function postedit(ConfigRequest $request)
    {
          $data = $request->validated();
          $ConfigModel=new ConfigModel;
          $edit=$ConfigModel->edit(['config_id'=>1],$data);
          if($edit){
              return rjson(1,'编辑成功！');
          }else{
              return rjson(0,'编辑失败！');
          }
    }

}
