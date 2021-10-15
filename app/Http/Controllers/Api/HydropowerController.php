<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\index\shop;
use App\Models\AreaModel;
use App\Models\HydropowerModel;
use App\Models\ShopMouthModel;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\PostDec;

class HydropowerController extends Controller
{
    protected  $request;
    protected $model;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->model = new HydropowerModel();
    }

    /**
     * 水电费登记
     * @return array
     */
    public function index(){
        $shop_model= new \App\Models\Shop();

        $year =  date('Y');
        $month =  date('n');
      $check_id =   $this->model->query()->where(['year'=>$year,'month'=>$month,'is_del'=>0])->select('shop_id')->get();
        $shop_id_array = [];
      if(!empty($check_id)){
          foreach($check_id as $value){
              $shop_id_array[] = $value->shop_id;
          }
      }
        $where = [];
        $area_id = $this->request->post('area_id');
        if(!empty($area_id)){
            $where = ['shop.area_id'=>$area_id];
        }
        $mouth_name = $this->request->post('mouth_name');
        if(!empty($mouth_name)){
            $where['shop_mouth.mouth_name'] = $mouth_name;
        }

        $data = $shop_model->index($where,1,["notin"=>['shop.id',$shop_id_array]]);
        $returnData = [];
        if(!empty($data['data'])){
            foreach($data['data'] as $key=>$v){
                $returnData[$key] =  ['id'=>$v['id'],'title'=>$v['area_name'].$v['mouth_name']];
                foreach($v['rant'] as $value){
                    if($value['type'] == 2){
                        $returnData[$key]['warte'][]  = $value;
                    }else{
                        $returnData[$key]['electric'][] = $value;
                }
            }
            }
        }
        $mouth_model = new ShopMouthModel();
        return rjson(200,'请求成功',$returnData);
    }

    /**
     * 添加水电表
     * @return array
     */
    public function addTable(){
       $user_id =  $this->request->get('id');
        $shop_id = $this->request->post('shop_id');
        $title =  $this->request->post('title');
        $multiple =  $this->request->post('multiple'); //为0的时候 是普通类型\
        $clear =  $this->request->post('clear');//默认4位
        $type = $this->request->post('type');//1 =>电  2=>水
        $Data = [
            'shop_id'=>$shop_id,
            'title' =>$title,
            'multiple' =>$multiple,
            'clear'  =>$clear,
            'type'  =>$type,
            'year' => date('Y'),
            'month' => date('n')
        ];
        $judge = $this->model->query()->insertGetId($Data);
        if($judge) {
            return rjson(200,'请求成功',$judge);
        }
        return rjson(0,'请求失败');
    }

    /**
     * 修改
     * @return array
     */
    public function set(){
        $user_id = $this->request->get('id');
        $hy_id = $this->request->post('hy_id');
        $parms = $this->request->post('.post');
        $judge = $this->model->edit(['id'=>$hy_id],$parms);
        if($judge){
            return rjson(200,'修改成功');
        }
        return rjson(0,'修改失败');
    }

    /**
     * 历史记录
     * @return array
     */
    public function record(){
        $user_id = $this->request->input();
        $where = [];
        $area_id = $this->request->post('area_id');
      if(!empty($area_id)){
          $where['area.id'] = $area_id;
      }


       $model  =  $this->model->query()->from('jh_warte_electric_rant as a')
            ->leftJoin('jh_user_shop as b','b.id','a.shop_id')
            ->leftJoin('jh_area as area','area.id','=','b.area_id')
            ->leftJoin('jh_shop_mouth as shop_mouth','shop_mouth.id',"=","b.mouth_id")
            ->where($where)
            ->select()->orderBy('a.id','desc');
        $mouth_name = $this->request->post('mouth_name');

       if(!empty($mouth_name)){
           $model->where('shop_mouth.mouth_name','like',"%$mouth_name%");
       }
       $start = $this->request->post('start');
       $end  = $this->request->post('end');
        if(!empty($start) && !empty($end)){
            $start = explode('-',$start);
            $end =  explode('-',$end);
            $year = [$start[0],$end[0]];
            $month = [$start[1],$end[1]];
            $model =  $model->whereBetween('year',$year)->whereBetween('month',$month);
        }
        $result = $model
            ->select([
                'a.shop_id','a.title','a.last_month','a.this_month','a.this_number','a.money',
                'shop_mouth.mouth_name','a.type','a.create_time','a.month','a.year','a.multiple'
                ])->paginate();
        $result = getPaginateData($result);
        $returnData  = [];
        if(!empty($result['data'])){
            foreach($result['data'] as $key=>$value){
                $time = $value->year."-".$value->month;
                if(array_key_exists($time,$returnData)){
                    if(array_key_exists($value->shop_id,$returnData[$time])){
                        if($value->type == 1){
                            $returnData[$time][$value->shop_id]['electricity_number'] +=$value->this_number;
                            array_push($returnData[$time][$value->shop_id]['electricity'],[
                                $value->title,$value->last_month,$value->this_month,$value->this_number
                            ]);
                        }else{
                            $returnData[$time][$value->shop_id]['water_number'] += $value->this_number;
                            array_push($returnData[$time][$value->shop_id]['water'],[
                                $value->title,$value->last_month,$value->this_month,$value->this_number
                            ]);
                        }
                        continue;
                    }
                }
                /**
                 * 第一个数据的值作为公共值
                 */
                $returnData[$time][$value->shop_id]['mouth_name'] = $value->mouth_name;
                $returnData[$time][$value->shop_id]['time']  = $time;
                if($value->type == 1 ){
                    //合计
                    $returnData[$time][$value->shop_id]['electricity_number'] = $value->this_number; //电
                    $returnData[$time][$value->shop_id]['water_number'] = 0;//水
                    $returnData[$time][$value->shop_id]['electricity'][] = [
                        $value->title,$value->last_month,$value->this_month,$value->this_number
                    ];
                    $returnData[$time][$value->shop_id]['water'] = [];
                }else{
                    //合计
                    $returnData[$time][$value->shop_id]['water_number'] = $value->this_number;//水
                    $returnData[$time][$value->shop_id]['electricity_number'] = 0;//电
                    $returnData[$time][$value->shop_id]['water'][] = [
                        $value->title,$value->last_month,$value->this_month,$value->this_number
                    ];
                    $returnData[$time][$value->shop_id]['electricity'] = [];
                }
             }
        }
        $returnData = array_values($returnData);
        foreach ($returnData as $key=>$v){
            $returnData[$key]  = array_values($returnData[$key]);
        }

        return rjson(200,'加载成功',$returnData);
    }
}