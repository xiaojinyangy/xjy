<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\AreaModel;
use App\Models\HydropowerModel;
use App\Models\shopRantModel;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Http\Request;

class shopRantController extends Controller
{
    protected $model;
    protected $request;
    public function  __construct(Request $request)
    {
        $this->model = new shopRantModel();
        $this->request = $request;
    }

    public function index(){
        if($this->request->method() == "POST"){
            $wheres = [];
            $where =[];
           $search = $this->request->post('form');
            $search = Ajax_Arr($search);
            if(isset($search['area_id'])) $wheres['c.id'] = $search['area_id'];
            if(isset($search['mouth_name'])) $wheres['d.mouth_name'] = $search['mouth_name'];
            if(isset($search['status'])) $where['a.status'] = $search['status'];
            if(isset($search['data'])){
                $data_slot =  explode('--',$search['data']);
                $start = explode('-',$data_slot[0]);
                $end =  explode('-',$data_slot[1]);
                $year = [$start[0],$end[0]];
                $month = [$start[1],$end[1]];
                $where['data'] = ['year'=>$year,'month'=>$month];
            }
            $result =  $this->model->index($where,$wheres);
           foreach($result['data'] as &$value){
               $value['button'] = "";
               if($value['pay_status'] ==0 ){
                   $value['button'] = "<a class=\"layui-btn layui-btn-primary layui-btn-sm\" lay-event=\"detail\">确认支付</a>";
               }
               if(empty($value['invoice'])){
                   $value['button'] .= "<a class=\"layui-btn layui-btn-danger layui-btn-sm\" lay-event=\"uppay\">上传发票</a>";
               }
           }
           return rjson('0','加载成功',$result);
        }
        $area_model = new AreaModel();
        $area_list = $area_model->index();
        return view('admin.rant.index',compact('area_list'));
    }

    public function surePay(){
        $id =   $this->request->post('id');
       $bool =  $this->model->query()->where(['id'=>$id])->update(['pay_status'=>1,'status'=>1,'pay_time'=>time()]);
       if($bool){
           return rjson(200,'支付成功');
       }
       return rjson(0,'确认支付失败');
    }

    public function invoice(){
        $id =  $this->request->post('id');
        if($this->request->method() == "POST"){
            $invoice =   $this->request->post('invoice');
            $bool =  $this->model->query()->where(['id'=>$id])->update(['invoice'=>$invoice]);
            if($bool){
                return rjson(200,'上传成功');
            }
            return rjson(0,'上传失败');
        }
            return view('admin.rant.invoice',compact('id'));
    }
}