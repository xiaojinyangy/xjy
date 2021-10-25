<?php


namespace App\Models;

class HydropowerModel extends Base
{

    protected $table = "jh_warte_electric_rant";
    protected $primaryKey = 'id';
    const CREATED_AT = "create_time";
    const UPDATED_AT = "update_time";

    public function index($where=['a.is_del'=>0]){
        $result =  $this->query()->from('jh_warte_electric_rant as a')
            ->leftJoin('jh_user_shop as b','a.shop_id','b.id')
            ->leftJoin('jh_area as c','c.id','b.area')
            ->leftJoin('jh_shop_mouth as d','d.id','b.mouth')
            ->where($where)
            ->select(['a.*','c.area_name','d.mouth_name']);
        $result =  $result->paginate();
        $result = getPaginateData($result);
        $New_result = [];
        if(!empty($result['data'])){
            foreach ($result['data'] as $key=>$v){
                $New_result["$v[shop_id]$v[year]$v[month]"]['area_name'] = $v['area_name'];
                $New_result["$v[shop_id]$v[year]$v[month]"]['mouth_name'] = $v['mouth_name'];
                $New_result["$v[shop_id]$v[year]$v[month]"]['date'] = $v['year'] .'-'.$v['month'];
                unset($v['area_name'],$v['mouth_name']);
                if($v['type'] == 1 ){ //电费
                    $New_result["$v[shop_id]$v[year]$v[month]"]['key'] = $key+1;
                    $New_result["$v[shop_id]$v[year]$v[month]"]['electric_title'] = $v['title'];
                    $New_result["$v[shop_id]$v[year]$v[month]"]['electric_last_month'] = $v['last_month'];
                    $New_result["$v[shop_id]$v[year]$v[month]"]['electric_this_month'] = $v['this_month'];
                    $New_result["$v[shop_id]$v[year]$v[month]"]['electric_this_number'] = $v['this_number'];
                }else{
                    $New_result["$v[shop_id]$v[year]$v[month]"]['warte_title']  = $v['title'];
                    $New_result["$v[shop_id]$v[year]$v[month]"]['warte_last_month'] = $v['last_month'];
                    $New_result["$v[shop_id]$v[year]$v[month]"]['warte_this_month'] = $v['this_month'];
                    $New_result["$v[shop_id]$v[year]$v[month]"]['warte_this_number'] = $v['this_number'];
                }
            }
        }
        return $New_result;
    }

}