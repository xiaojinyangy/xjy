<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobModel;
use App\Models\rantRecordModel;
use App\Models\Shop;
use App\Models\shopRantModel;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use App\Models\Admin as AdminModel;
use App\Models\Nav as NavModel;
use App\Models\Config as ConfigModel;
use App\NewClass\Auth\Auth as AuthModel;//后台权限认证类

class IndexController extends Controller
{    
	//菜单栏目
    public function index(Request $request)
    {  
        //加载菜单 根据权限判断 再分级
        $NavModel=new NavModel;
        $menulist=$NavModel->getlist([],[],['nav_order,asc'])->toArray();
        
        $AuthModel=new AuthModel;
        $admin_id=$request->session()->get('admin_id');
        $menu=[];
        foreach ($menulist as $key => $value) {
            if(!$AuthModel->check($value['nav_url'],$admin_id)){
                 unset($menulist[$key]);
            }else{
               if($value['parent_id']==0){
                $menu['top'][]=$menulist[$key];
               }else{
                    $menu['secondary'][]=$menulist[$key];
               }
            }
        }
        $menu_arr=[];
        if(isset($menu['top'])){
            foreach ($menu['top'] as $key => $value) {
                $menu_arr['top'][]=$menu['top'][$key];
                foreach ($menu['secondary'] as $k => $v) {
                                if($v['parent_id']==$value['nav_id']){
                                      $menu_arr['top'][$key]['secondary'][]=$menu['secondary'][$k];
                                }
                }
            }
        }
        
        
        //配置查询
        $ConfigModel=new ConfigModel;
        $config=$ConfigModel->getone(['config_id'=>1],['config_title','config_keywords','config_desc']);

        //管理员查询
        $AdminModel=new AdminModel;
        $admin=$AdminModel->getone(['admin_id'=>$admin_id],['admin_name','admin_img','admin_level']);

        $data=[
         'menu_arr'=>$menu_arr,
         'config'=>$config,
         'admin'=>$admin,
        ];

        return view('admin.index.index',$data);
    }
     
    //首页
    public function indexv1()
    {
        /** 用户总数 */
        $user_model = new User();
        $user_number = $user_model->query()->where('is_del',0)->count();
        /**
         * 员工总数
         */
        $job_model = new JobModel();
        $job_number = $job_model->query()->count();

        /**
         * 店铺总数
         */
        $shop_model = new Shop();
        $shop_number = $shop_model->query()->where('is_del',0)->count();
        /**
         * 日 缴费
         */
        $rant_model = new rantRecordModel();
        $day_rant_money = $rant_model->query()->whereDate('create_time',date('Y-m-d'))->sum('money');

        /** 月缴费 */
        $rant_model = new rantRecordModel();
        $thisMonth = date('Y-m-d',strtotime('first day of this month'));
        $lastMonth =date('Y-m-d',strtotime('first day of +1 month'));
        $month_rant_money =  $rant_model->query()->whereBetween('create_time',[$thisMonth,$lastMonth])->sum('money');

        /** 总缴费 */
        $rant_model = new rantRecordModel();
        $rant_money_number = $rant_model->query()->sum('money');
        $result = [
            'user_number' => $user_number,
            'job_number'  =>$job_number,
            'shop_number' => $shop_number,
            'day_rant_money' => $day_rant_money,
            'month_rant_money' => $month_rant_money,
            'rant_money_number'=>$rant_money_number
        ];
        return view('admin.index.indexv1',compact('result'));
    }

    //修改密码
    public function editpass()
    {  
        return view('admin.index.editpass');
    }

    //修改密码-提交
    public function posteditpass(Request $request)
    {  
            $admin_id=$request->session()->get('admin_id');
            $data=$request->all();
            if(empty($data['admin_pwd'])){
                 return rjson(0,'密码不能为空！');
            }elseif(empty($data['admin_pwds'])){
                 return rjson(0,'确认密码不能为空！');
            }elseif($data['admin_pwd']!=$data['admin_pwds']){
                 return rjson(0,'密码不相同！');
            }
           
            $AdminModel=new AdminModel;
            $edit=$AdminModel->edit(['admin_id'=>$admin_id],['admin_pwd'=>Hash::make($data['admin_pwd'])]);
            if($edit){
                return rjson(1,'编辑成功！');
            }else{
                return rjson(0,'编辑成功！');
            }
    }
}
