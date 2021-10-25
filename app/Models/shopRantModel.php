<?php


namespace App\Models;


use function foo\func;

class shopRantModel extends Base
{
    protected  $primaryKey = 'id';
    protected  $table = 'jh_shop_pay_rant';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'create_time';
    public function index($where=[],$wheres =[]){
        $where['a.is_del'] = 0;
        $pages = 15;
        $warte_electric = new HydropowerModel();
        $warte_electric_list = $warte_electric->index($wheres);  //水电费列表
        if(isset($wheres)) $pages = 40;

       $result =  $this->query()->from('jh_shop_pay_rant as a')->where($where)
            ->orderBy('id','desc')
            ->leftJoin('jh_area_rant_ext as b','b.id','a.area_rant_ext_id')
           ->leftJoin('jh_user_shop as p','p.id','a.shop_id')
           ->leftJoin('jh_area_rent as c','c.area_id','p.area');
           if(array_key_exists('data',$where)){
               if(!empty($year) && !empty($month)){
                   $result =  $result->whereBetween('a.year',$year)->whereBetween('a.month',$month);
               }
           }
           $allData = $result->select([
               'a.id','a.pay_status','a.status','a.pay_user','a.shop_id','a.year','a.month','a.area_rant_ext_id','a.invoice',
               'b.rant_money',
               'p.name',
               'c.rent_money','c.area_rent_money','c.incidental_money','c.water_money','c.electric_money'
           ])->get();
           if(!empty($allData)){
              $total =  $this->total($allData->toArray(),$warte_electric_list);
           }

        $result = $result->where($where)->select([
               'a.id','a.pay_status','a.status','a.pay_user','a.shop_id','a.year','a.month','a.area_rant_ext_id','a.invoice',
               'b.rant_money',
               'p.name',
               'c.rent_money','c.area_rent_money','c.incidental_money','c.water_money','c.electric_money'
               ])->paginate($pages);
//
        $result = getPaginateData($result);
        $result['sum'] = $total;
        if(!empty($result['data'])){
            foreach($result['data'] as $key=>&$v){
                $keys = "$v[shop_id]$v[year]$v[month]";
                $v['key'] = $key+1;
                if(!isset($warte_electric_list[$keys])){
                    unset($result['data'][$key]);
                    continue;
                }
                $v =  array_merge($v->toArray(),$warte_electric_list[$keys]);
                $v['electric_this_money'] = bcmul($v['warte_this_number'],$v['electric_money'],2);//水费
                $v['water_this_money'] = bcmul($v['warte_this_number'],$v['water_money'],2); //电费

                $v['sum_money'] = bcadd($v['electric_this_money'],$v['water_this_money'],2); //水电
                $v['sum_money'] = bcadd($v['sum_money'],$v['rent_money'],2);//+房租
                $v['sum_money'] = bcadd($v['sum_money'],$v['area_rent_money'],2);//+特定区域管理费
                $v['sum_money'] = bcadd($v['sum_money'],$v['incidental_money'],2);//+综合费
                $v['area_rant_ext'] = 0;
                if($v['area_rant_ext_id'] != 0){
                    $v['area_rant_ext'] = $v['rant_money'];
                    $v['sum_money'] = bcadd($v['sum_money'],$v['rant_money'],2);//+额外费用
                }

                if($v['status'] == 0){
                    $v['status'] = '未缴费';
                    $v['pay_type'] = "-";
                }else if($v['status'] == 2 && $v['pay_status'] == 0){
                    $v['status'] = '未缴费';
                    $v['pay_type'] = "-";
                }else if($v['pay_status'] == 1){
                    $v['status'] = '已缴费';
                    if($v['pay_user'] == 0){
                        $v['pay_type'] = "线下支付";
                    }else if($v['pay_user']  ==  1){
                        $v['pay_type'] = "线上支付";
                    }
                }
            }
        }
        return $result;
    }

    public function total($allData = [],$warte_electric_list){
       if(is_array($allData) && !empty($allData)){
           $result = [
               'rent_money' => 0,
               'electric_this_money' => 0,
               'water_this_money' => 0,
               'area_rent_money' => 0,
               'incidental_money'=>0
           ];
           foreach($allData as $key=>$v){
               $keys = "$v[shop_id]$v[year]$v[month]";
               if(!isset($warte_electric_list[$keys])){
                   unset($allData[$key]);
                   continue;
               }
               $v['key'] = $key+1;
               $v =  array_merge($v,$warte_electric_list[$keys]);
               $result['water_this_money'] += bcmul($v['warte_this_number'],$v['electric_money'],2);//水费
               $result['electric_this_money'] += bcmul($v['warte_this_number'],$v['water_money'],2); //电费
               $result['rent_money'] += $v['rent_money']; //租金
               $result['area_rent_money'] +=$v['area_rent_money'];//特定区域管理费
               $result['incidental_money'] +=$v['incidental_money'];//综合费
           }
           $result['sum'] = $result['water_this_money'] + $result['electric_this_money'] + $result['rent_money'] + $result['area_rent_money'] + $result['incidental_money'];
          // var_dump($result);
        return $result;
       }
       return 0;
    }
}