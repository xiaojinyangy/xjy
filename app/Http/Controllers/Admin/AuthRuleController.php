<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Models\AuthRule as AuthRuleModel;//权限模型
use App\Models\AuthGroup as AuthGroupModel;//后台管理组模型
use App\Http\Requests\admin\AuthRule as AuthRuleRequest;//权限验证表单

class AuthRuleController extends Controller
{    
	  //列表
    public function index()
    {    
        $AuthRuleModel=new AuthRuleModel;
        $rule=$AuthRuleModel->getlist([],[])->toArray();
        $rules=[];
        foreach ($rule as $key => $value) {
          if($value['parent_id']==0){
                $rules['top'][]=$rule[$key];
          }else{
            $rules['secondary'][]=$rule[$key];
          }
        }
        $arr=[];
        foreach ($rules['top'] as $key => $value) {
          $arr['top'][]=$rules['top'][$key];
          foreach ($rules['secondary'] as $k => $v) {
            if($v['parent_id']==$value['rule_id']){
                      $arr['top'][$key]['secondary'][]=$rules['secondary'][$k];
            }
          }
        }

        $data=[
          'rule'=>$arr
        ];
        return view('admin.authrule.index',$data);
    }
    
    //添加
    public function add()
    {   
        $AuthRuleModel=new AuthRuleModel;
        $authrule=$AuthRuleModel->getlist(['parent_id'=>0],[]);
        $data=[
          'authrule'=>$authrule,
        ];
        return view('admin.authrule.add',$data);
    }
    
    //添加-提交
    public function postadd(AuthRuleRequest $request)
    {     
          $validated = $request->validated();
          $AuthRuleModel=new AuthRuleModel;
          $add=$AuthRuleModel->add($validated);
          if($add){
              //添加超级管理的的权限
              $AuthGroupModel=new AuthGroupModel;
              $authgroup=$AuthGroupModel->getone(['level'=>1]);
              $rule=$authgroup->rule_id.','.$add;
              $AuthGroupModel->edit(['group_id'=>$authgroup->group_id],['rule_id'=>$rule]);
              return rjson(1,'添加成功！');
          }else{
              return rjson(0,'添加失败！');
          }
    }
     
    //编辑
    public function edit(Request $request,$id)
    {   
        $AuthRuleModel=new AuthRuleModel;
        $authrules=$AuthRuleModel->getlist(['parent_id'=>0],[]);
        $authrule=$AuthRuleModel->getone(['rule_id'=>$id],[]);
        $data=[
          'authrules'=>$authrules,
          'authrule'=>$authrule,
        ];
        return view('admin.authrule.edit',$data);
    }
    
    //编辑-提交
    public function postedit(AuthRuleRequest $request,$id)
    {
          $validated = $request->validated();
          $AuthRuleModel=new AuthRuleModel;
          $edit=$AuthRuleModel->edit(['rule_id'=>$id],$validated);
          if($edit){
              return rjson(1,'编辑成功！');
          }else{
              return rjson(0,'编辑失败！');
          }
    }

    //删除
    public function del(Request $request,$id)
    {  
        $AuthRuleModel=new AuthRuleModel;
        $authrule=$AuthRuleModel->getone(['parent_id'=>$id],[]);
        if(!empty($authrule)){
           return rjson(0,'请先删除下级权限！');
        }
        $del=$AuthRuleModel->del(['rule_id'=>$id]);
        if($del){
            //清除包含被删除的权限
            $AuthGroupModel=new AuthGroupModel;
            $where=[];
            $grouplist=$AuthGroupModel->getlist($where,[])->toArray();
            foreach ($grouplist as $key => $value) {
               $rule=explode(',', $value['rule_id']);
               foreach ($rule as $k => $val) {
                  if($val==$rule_id){
                           unset($rule[$k]);
                  }
               }
               $rule=implode(',',$rule);
               $edit=$AuthGroupModel->edit(['group_id'=>$value['group_id']],['rule_id'=>$rule]);
            }
           return rjson(1,'删除成功！');
        }else{
           return rjson(0,'删除失败！');
        }
    }
    
    //禁用
    public function ban(Request $request,$id)
    {
        $AuthRuleModel=new AuthRuleModel;
        $edit=$AuthRuleModel->edit(['rule_id'=>$id],['rule_status'=>0]);
        if($edit){
           return rjson(1,'禁用成功！');
        }else{
           return rjson(0,'禁用失败！');
        }
    }
    
    //启用
    public function cancelban(Request $request,$id)
    {
        $AuthRuleModel=new AuthRuleModel;
        $edit=$AuthRuleModel->edit(['rule_id'=>$id],['rule_status'=>1]);
        if($edit){
           return rjson(1,'启用成功！');
        }else{
           return rjson(0,'启用失败！');
        }
    }

}
