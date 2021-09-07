<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Models\Nav as NavModel;//菜单模型
use App\Http\Requests\admin\Nav as NavRequest;//菜单验证表单

class NavController extends Controller
{    
	//菜单列表
    public function index()
    {    
        $NavModel=new NavModel;
        $nav=$NavModel->getlist([],[],['nav_order,asc'])->toArray();
        $navs=[];
        foreach ($nav as $key => $value) {
            if($value['parent_id']==0){
                $navs['top'][]=$nav[$key];
            }else{
                $navs['secondary'][]=$nav[$key];
            }
        }
        $arr=[];
        foreach ($navs['top'] as $key => $value) {
            $arr['top'][]=$navs['top'][$key];
            foreach ($navs['secondary'] as $k => $v) {
                if($v['parent_id']==$value['nav_id']){
                      $arr['top'][$key]['secondary'][]=$navs['secondary'][$k];
                }
            }
        }

        $data=[
          'nav'=>$arr
        ];
        return view('admin.nav.index',$data);
    }
    
    //添加
    public function add()
    {   
        $NavModel=new NavModel;
        $nav=$NavModel->getlist(['parent_id'=>0],[]);
        $data=[
          'nav'=>$nav,
        ];
        return view('admin.nav.add',$data);
    }
    
    //添加-提交
    public function postadd(NavRequest $request)
    {     
          $validated = $request->validated();
          $NavModel=new NavModel;
          $add=$NavModel->add($validated);
          if($add){
              return rjson(1,'添加成功！');
          }else{
              return rjson(0,'添加失败！');
          }
    }
     
    //编辑
    public function edit(Request $request,$id)
    {   
        $NavModel=new NavModel;
        $navs=$NavModel->getlist(['parent_id'=>0],[]);
        $nav=$NavModel->getone(['nav_id'=>$id],[]);
        $data=[
          'navs'=>$navs,
          'nav'=>$nav,
        ];
        return view('admin.nav.edit',$data);
    }
    
    //编辑-提交
    public function postedit(NavRequest $request,$id)
    {
          $validated = $request->validated();
          $NavModel=new NavModel;
          $edit=$NavModel->edit(['nav_id'=>$id],$validated);
          if($edit){
              return rjson(1,'编辑成功！');
          }else{
              return rjson(0,'编辑失败！');
          }
    }

    //删除
    public function del(Request $request,$id)
    {  
        $NavModel=new NavModel;
        $nav=$NavModel->getone(['parent_id'=>$id],[]);
        if(!empty($nav)){
           return rjson(0,'请先删除下级菜单！');
        }
        $del=$NavModel->del(['nav_id'=>$id]);
        if($del){
           return rjson(1,'删除成功！');
        }else{
           return rjson(0,'删除失败！');
        }
    }

}
