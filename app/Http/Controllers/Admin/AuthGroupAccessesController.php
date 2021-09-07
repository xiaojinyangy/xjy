<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Models\AuthGroup as AuthGroupModel;//后台管理组模型
use App\Models\AuthRule as AuthRuleModel;//权限模型
use App\Models\Admin as AdminModel;//管理员模型
use App\Models\AuthGroupAccesses as AuthGroupAccessesModel;//管理组与权限关系模型
use App\Http\Requests\admin\AuthGroupAccesses as AuthGroupAccessesRequest;//管理组与权限关系验证表单

class AuthGroupAccessesController extends Controller
{    
	  //列表
    public function index(Request $request,$id)
    {   
        $data = $request->all();
        $AuthGroupAccessesModel = new AuthGroupAccessesModel;
        $where=['group_id'=>$id];
        $admin_name = empty($data['admin_name']) ? '' : $data['admin_name'];
        if(!empty($admin_name)){
              $where[] = ['admin_name','like',"%$admin_name%"];
        }
        $authgroupaccesses = $AuthGroupAccessesModel->getlists($where,[],[],[],['admin','group']);
        
        $data=[
          'admin_name'=>$admin_name,
          'authgroupaccesses'=>$authgroupaccesses,
          'group_id'=>$id,
        ];
        return view('admin.authgroupaccesses.index',$data);
    }
    
    //添加
    public function add(Request $request,$id)
    {   
        //查询管理员
        $data = $request->all();
        $AdminModel = new AdminModel;
        $admin_where=[];
        $admin_name = empty($data['admin_name']) ? '' : $data['admin_name'];
        if(!empty($admin_name)){
              $admin_where[] = ['admin_name','like',"%$admin_name%"];
        }
        $admins = $AdminModel->getlist($admin_where,['admin_id','admin_name'])->toArray();
        $admins_id=array_column($admins, 'admin_id');

        $AuthGroupAccessesModel=new AuthGroupAccessesModel;
        $auth_admin=$AuthGroupAccessesModel->getlist([],['admin_id'])->toArray();
        $auth_admin_id=array_column($auth_admin, 'admin_id');

        //取交集 把存在的去除掉
        $ids=array_diff($admins_id,$auth_admin_id);
        foreach ($admins as $key => $value) {
           if(!in_array($value['admin_id'], $ids)){
                unset($admins[$key]);
           }
        }

        $data=[
          'group_id'=>$id,
          'admin_name'=>$admin_name,
          'admins'=>$admins,
        ];

        return view('admin.authgroupaccesses.add',$data);
    }
    
    //添加-提交
    public function postadd(AuthGroupAccessesRequest $request,$id)
    {     
          $validated = $request->validated();
          $AuthGroupAccessesModel=new AuthGroupAccessesModel;
          
          $arr=[];
          foreach ($validated['admin_id'] as $key => $value) {
              $data=[
                 'admin_id'=>$value,
                 'group_id'=>$id,
                 'created_at'=>date('Y-m-d H:i:s'),
                 'updated_at'=>date('Y-m-d H:i:s'),
              ];
              $arr[]=$data;
          }
          $add=AuthGroupAccessesModel::insert($arr);
          if($add){
              return rjson(1,'添加成功！');
          }else{
              return rjson(0,'添加失败！');
          }
    }

    //删除
    public function del(Request $request,$id)
    {  
        $AuthGroupAccessesModel=new AuthGroupAccessesModel;
        $accesses=$AuthGroupAccessesModel->getone(['accesses_id'=>$id],[],['admin']);
        if($accesses->admin->admin_id==1){
           return rjson(0,'禁止删除！');
        }
        $del=$AuthGroupAccessesModel->del(['accesses_id'=>$id]);
        if($del){
           return rjson(1,'删除成功！');
        }else{
           return rjson(0,'删除失败！');
        }
    }

}
