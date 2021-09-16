<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\HydropowerModel;
use Illuminate\Http\Request;

class HydropowerController extends  Controller
{
    protected $model;
    protected $request;
    public function  __construct(Request $request)
    {
        $this->model = new HydropowerModel();
        $this->request = $request;
    }

    public function index(){
        if($this->request->method() == "POST"){
            $area = $this->request->post('area');
            if(!empty($area)) $where['b.area_id'] = $area;
            $month = $this->request->post('month');
            if(!empty($month)) $where['b.month_id'] = $month;
            $whereTimeStart = $this->request->post('start');
            $whereTimeEnd = $this->request->post('end');
            $where = ['a.id_del'=>0];
           $result =  $this->model->query()->from('jh_warte_electric_rant as a')
                ->leftJoin('jh_user_shop as b','a.shop_id','b.id')
                ->where($where);
           if(!empty($whereTimeStart) && !empty($whereTimeEnd)){
               $result->whereBetween('create_time',[$whereTimeStart,$whereTimeEnd]);
           }
            $result->paginate();
            $result = getPaginateData($result);
            if(!empty($result['data'])){
                foreach ($result['data'] as $key=>$value){
                    $result['data'][$key]['key'] = $key+1;
                }
            }
            return rjson(0,'加载成功',$result);
        }
        return view('admin.hydropower.index');
    }
}