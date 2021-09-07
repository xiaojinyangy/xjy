<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Models\AuthGroup as AuthGroupModel;//后台管理组模型
use App\Models\AuthRule as AuthRuleModel;//权限模型
use App\Http\Requests\admin\AuthGroup as AuthGroupRequest;//后台管理组验证表单

class AuthGroupController extends Controller
{    
	  //列表
    public function index(Request $request)
    {   
        $data = $request->all();
        $AuthGroupModel = new AuthGroupModel();
        $where=[];

        ///管理组名称
        $group_name = empty($data['group_name']) ? '' : $data['group_name'];
        if(!empty($group_name)){
          $where[] =['group_name','like',"%$group_name%"];
        }

        $AuthGroupModel=new AuthGroupModel;
        $authgroup=$AuthGroupModel->getlists($where,[]);
        $data=[
          'group_name'=>$group_name,
          'authgroup'=>$authgroup,
        ];
        return view('admin.authgroup.index',$data);
    }
    
    //添加
    public function add()
    {   
        $data=[
        ];
        return view('admin.authgroup.add',$data);
    }
    
    //添加-提交
    public function postadd(AuthGroupRequest $request)
    {     
          $validated = $request->validated();
          $AuthGroupModel=new AuthGroupModel;
          $validated['rule_id']='1,2,3,4';//默认权限
          $add=$AuthGroupModel->add($validated);
          if($add){
              return rjson(1,'添加成功！');
          }else{
              return rjson(0,'添加失败！');
          }
    }
     
    //编辑
    public function edit(Request $request,$id)
    {   
        $AuthGroupModel=new AuthGroupModel;
        $authgroup=$AuthGroupModel->getone(['group_id'=>$id],[]);
        $data=[
          'authgroup'=>$authgroup,
        ];
        return view('admin.authgroup.edit',$data);
    }
    
    //编辑-提交
    public function postedit(AuthGroupRequest $request,$id)
    {
          $validated = $request->validated();
          $AuthGroupModel=new AuthGroupModel;
          $edit=$AuthGroupModel->edit(['group_id'=>$id],$validated);
          if($edit){
              return rjson(1,'编辑成功！');
          }else{
              return rjson(0,'编辑失败！');
          }
    }

    //删除
    public function del(Request $request,$id)
    {  
        $AuthGroupModel=new AuthGroupModel;
        $authrule=$AuthGroupModel->getone(['group_id'=>$id,'level'=>1],[]);
        if(!empty($authrule)){
           return rjson(0,'禁止删除！');
        }
        $del=$AuthGroupModel->del(['group_id'=>$id]);
        if($del){
           return rjson(1,'删除成功！');
        }else{
           return rjson(0,'删除失败！');
        }
    }
    
    //禁用
    public function ban(Request $request,$id)
    {
        $AuthGroupModel=new AuthGroupModel;
        $edit=$AuthGroupModel->edit(['group_id'=>$id],['group_status'=>0]);
        if($edit){
           return rjson(1,'禁用成功！');
        }else{
           return rjson(0,'禁用失败！');
        }
    }
    
    //启用
    public function cancelban(Request $request,$id)
    {
        $AuthGroupModel=new AuthGroupModel;
        $edit=$AuthGroupModel->edit(['group_id'=>$id],['group_status'=>1]);
        if($edit){
           return rjson(1,'启用成功！');
        }else{
           return rjson(0,'启用失败！');
        }
    }
     
    //分配权限
    public function allocate(Request $request,$id)
    {   
        //查询规则
        $AuthRuleModel=new AuthRuleModel;
        //查询最顶级
        $top_where=['parent_id'=>0];
        $top_field=['parent_id','rule_id','rule_name'];
        $top=$AuthRuleModel->getlist($top_where,$top_field)->toArray();
        //查询次级
        $secondary_where=[['parent_id','!=',0]];
        $secondary_field=['parent_id','rule_id','rule_name'];
        $secondary=$AuthRuleModel->getlist($secondary_where,$secondary_field)->toArray();
        foreach ($top as $key => $value) {
          $top[$key]['secondary']=[];
          if(!empty($secondary)){
              foreach ($secondary as $k => $v) {
                if($value['rule_id']==$v['parent_id']){
                        $top[$key]['secondary'][]=$secondary[$k];
                }
              }
          }
        }

        //查询选中规则
        $AuthGroupModel=new AuthGroupModel;
        $authgroup_where=['group_id'=>$id];
        $authgroup_field=['rule_id'];
        $authgroup=$AuthGroupModel->getone($authgroup_where,$authgroup_field);
        if(!empty($authgroup)){
            $authgroup=$authgroup->toArray();
            $authgroup=explode(',',$authgroup['rule_id']);
        }
        $data=[
          'top'=>$top,
          'group_id'=>$id,
          'authgroup'=>$authgroup,
        ];
        return view('admin.authgroup.allocate',$data);
    }
    
    //编辑权限
    public function postallocate(Request $request,$id)
    {   
        $post=$request->all();
        $data=[];
        if(is_array($post['rule_id'])){
          $data['rule_id']=implode(',', $post['rule_id']);
        }
        if(empty($data)){
           return rjson(0,'分配失败！');
        }
        $where=['group_id'=>$id];
        $AuthGroupModel=new AuthGroupModel;
        $edit=$AuthGroupModel->edit($where,$data);
        if($edit){
           return rjson(1,'分配成功！');
        }else{
           return rjson(0,'分配失败！');
        }
    }

}
