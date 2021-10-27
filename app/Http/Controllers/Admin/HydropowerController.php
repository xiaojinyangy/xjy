<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\AreaModel;
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
           $search = $this->request->post('form');
            $search = Ajax_Arr($search);
            $where = ['a.is_del'=>0];
            if(isset($search['area'])) $where['b.area'] = $search['area'];
            if(isset($search['mouth_name'])) $where['d.mouth_name'] = $search['mouth_name'];
            if(isset($search['data'])){
                $data_slot =  explode('--',$search['data']);
                $start = explode('-',$data_slot[0]);
                $end =  explode('-',$data_slot[1]);
                $year = [$start[0],$end[0]];
                $month = [$start[1],$end[1]];
            }


           $result =  $this->model->query()->from('jh_warte_electric_rant as a')
               ->leftJoin('jh_user_shop as b','a.shop_id','b.id')
               ->leftJoin('jh_area as c','c.id','b.area')
               ->leftJoin('jh_shop_mouth as d','d.id','b.mouth')
                ->where($where)
                ->select(['a.*','c.area_name','d.mouth_name']);
           if(!empty($year) && !empty($month)){
               $result =  $result->whereBetween('a.year',$year)->whereBetween('a.month',$month);
           }
            $result =  $result->paginate();
            $result = getPaginateData($result);
              $New_result = [];
            if(!empty($result['data'])){
                foreach ($result['data'] as $key=>$v){
                    $New_result['data']["$v[shop_id]$v[year]$v[month]"]['area_name'] = $v['area_name'];
                    $New_result['data']["$v[shop_id]$v[year]$v[month]"]['mouth_name'] = $v['mouth_name'];
                    $New_result['data']["$v[shop_id]$v[year]$v[month]"]['date'] = $v['year'] .'-'.$v['month'];
                    $New_result['data']["$v[shop_id]$v[year]$v[month]"]['shop_id'] = $v['shop_id'];
                    if($v['type'] == 1 ){ //电费
                        $New_result['data']["$v[shop_id]$v[year]$v[month]"]['key'] = $key+1;
                        $New_result['data']["$v[shop_id]$v[year]$v[month]"]['electric_title'] = $v['title'];
                        $New_result['data']["$v[shop_id]$v[year]$v[month]"]['electric_last_month'] = $v['last_month'];
                        $New_result['data']["$v[shop_id]$v[year]$v[month]"]['electric_this_month'] = $v['this_month'];
                        $New_result['data']["$v[shop_id]$v[year]$v[month]"]['electric_this_number'] = $v['this_number'];
                    }else{
                        $New_result['data']["$v[shop_id]$v[year]$v[month]"]['warte_title']  = $v['title'];
                        $New_result['data']["$v[shop_id]$v[year]$v[month]"]['warte_last_month'] = $v['last_month'];
                        $New_result['data']["$v[shop_id]$v[year]$v[month]"]['warte_this_month'] = $v['this_month'];
                        $New_result['data']["$v[shop_id]$v[year]$v[month]"]['warte_this_number'] = $v['this_number'];
                    }
                }
            }
            $page =  $this->request->input('page');
            $limit =  $this->request->input('limit');
            $New_result['currentPage'] = isset($page) ? $page : 1 ;
            $New_result['perPage'] =  isset($limit) ? $limit : 1 ;
            $New_result['total'] = isset($New_result['data']) ? count($New_result['data']) :0;
            $New_result['lastPage'] =  ceil($New_result['total'] / 15);
            $New_result['data'] = isset($New_result['data']) ?  array_values($New_result['data']) : [];
            return rjson(0,'加载成功',$New_result);
        }
        $area_model = new AreaModel();
        $area_list = $area_model->index();
        return view('admin.hydropower.index',compact('area_list'));
    }
}