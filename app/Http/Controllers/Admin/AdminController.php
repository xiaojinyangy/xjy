<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin as AdminModel;//后台管理组模型
use App\Models\AuthGroupAccesses as AuthGroupAccessesModel;//管理组和管理员关系模型
use App\Http\Requests\admin\Admin as AdminRequest;//后台管理组验证表单
use App\Http\Requests\admin\AdminEdit as AdminEditRequest;//后台管理组验证表单

class AdminController extends Controller
{    
	  //列表
    public function index(Request $request)
    {   
        $data = $request->all();
        $AdminModel = new AdminModel();
        $where=[];

        //管理组名称
        $admin_name = empty($data['admin_name']) ? '' : trim($data['admin_name']);
        if(!empty($admin_name)){
          $where[] =['admin_name','like',"%$admin_name%"];
        }
        //状态
        $admin_show = empty($data['admin_show']) ? '' : $data['admin_show'];
        if(!empty($admin_show)){
          $where[] =['admin_show','=',"$admin_show"];
        }

        /*时间*/
        $start_time=empty($data['start_time']) ? '' : $data['start_time'];
        $end_time=empty($data['end_time']) ? '' : $data['end_time'];
        if(!empty($start_time)&&!empty($end_time)){
               $where[] =['admin_time','BETWEEN',"$start_time,$end_time"];
        }

        $AdminModel=new AdminModel;
        $list=$AdminModel->getlists($where,[]);
        $data=[
          'admin_name'=>$admin_name,
          'admin_show'=>$admin_show,
          'start_time'=>$start_time,
          'end_time'=>$end_time,
          'list'=>$list,
        ];
        return view('admin.admin.index',$data);
    }
    
    //添加
    public function add()
    {   
        $data=[
        ];
        return view('admin.admin.add',$data);
    }
    
    //添加-提交
    public function postadd(AdminRequest $request)
    {     
          $data = $request->validated();
          $AdminModel=new AdminModel;
          $admin=$AdminModel->getone(['admin_name'=>$data['admin_name']],['admin_id']);
          if(!empty($admin)){
              return rjson(0,'该管理员已存在！');
          }
          $data['admin_pwd']=Hash::make($data['admin_pwd']);
          $add=$AdminModel->add($data);
          if($add){
              return rjson(1,'添加成功！');
          }else{
              return rjson(0,'添加失败！');
          }
    }
    
    //编辑
    public function edit(Request $request,$id)
    {   
        $AdminModel=new AdminModel;
        $admin=$AdminModel->getone(['admin_id'=>$id],[]);
        $data=[
          'admin'=>$admin,
        ];
        return view('admin.admin.edit',$data);
    }
    
    //编辑-提交
    public function postedit(AdminEditRequest $request,$id)
    {
          $data = $request->validated();
          $AdminModel=new AdminModel;
          $where=[
              ['admin_name','=',$data['admin_name']],
              ['admin_id','<>',$id],
          ];
          $admin=$AdminModel->getone($where,['admin_id']);
          if(!empty($admin)){
              return rjson(0,'该管理员已存在！');
          }
          if(empty($data['admin_pwd'])){
               unset($data['admin_pwd']);
          }else{
               $data['admin_pwd']=Hash::make($data['admin_pwd']);
          }
          $edit=$AdminModel->edit(['admin_id'=>$id],$data);
          if($edit){
              return rjson(1,'编辑成功！');
          }else{
              return rjson(0,'编辑失败！');
          }
    }

    //删除
    public function del(Request $request,$id)
    {  
        $AdminModel=new AdminModel;
        $admin=$AdminModel->getone(['admin_id'=>$id,'admin_level'=>1],['admin_id']);
        if(!empty($admin)){
           return rjson(0,'禁止删除！');
        }
        $del=$AdminModel->del(['admin_id'=>$id]);
        if($del){
           //删除管理和管理组的关系
           $AuthGroupAccessesModel=new AuthGroupAccessesModel;
           $AuthGroupAccessesModel->del(['admin_id'=>$id]);
           return rjson(1,'删除成功！');
        }else{
           return rjson(0,'删除失败！');
        }
    }
    
    //禁用
    public function ban(Request $request,$id)
    {
        $AdminModel=new AdminModel;
        $edit=$AdminModel->edit(['admin_id'=>$id],['admin_show'=>2]);
        if($edit){
           return rjson(1,'禁用成功！');
        }else{
           return rjson(0,'禁用失败！');
        }
    }
    
    //启用
    public function cancelban(Request $request,$id)
    {
        $AdminModel=new AdminModel;
        $edit=$AdminModel->edit(['admin_id'=>$id],['admin_show'=>1]);
        if($edit){
           return rjson(1,'启用成功！');
        }else{
           return rjson(0,'启用失败！');
        }
    }

}
