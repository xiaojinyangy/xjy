<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\index\shop;
use App\Models\AreaModel;
use App\Models\HydropowerModel;
use App\Models\ShopMouthModel;
use Dotenv\Environment\DotenvVariables;
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
            $where[]= ['shop.area_id','=',$area_id];
        }
        $mouth_name = $this->request->post('mouth_name');
        if(!empty($mouth_name)){
            $where[] = ['shop_mouth.mouth_name','like',"%$mouth_name%"];
        }

        $data = $shop_model->index($where,1,["notin"=>['shop.id',$shop_id_array]]);
        $returnData = [];
        if(!empty($data)){
            foreach($data as $key=>$v){
                $returnData[$key] =  ['id'=>$v['id'],'area_name'=>$v['area_name'],'mouth_name'=>$v['mouth_name']];
                foreach($v['rant'] as $k=>$value){
                    if($value['type'] == 2){
                        $returnData[$key]['water'][] = [
                            'id'=>$value['id'],'name'=>$value['title'],"lastMonth"=>$value['last_month'],
                            "nowMonth"=> $value['this_month'],
                            "clear"=> $value['clear'],
                            "total"=>bcadd($value['this_number'],0,2)
                        ];
                    }else{
                        $returnData[$key]['electric'][] = [
                            'id'=>$value['id'],'name'=>$value['title'],"lastMonth"=>$value['last_month'],"type"=>$value['multiple'] > 0 ? "multiple" : "normal",
                            "nowMonth"=> $value['this_month'], "clear"=> $value['clear'],"total"=>bcadd($value['this_number'],0,2),"multiple"=>$value['multiple']
                        ];
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
        $shop_id = $this->request->post('id');
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
        /**
         * 添加和 修改  分段数据处理
         */
        $user_id = $this->request->get('id');
        $hy_id = $this->request->post('hy_id');
        $electricArray = $this->request->post('electric');
        $waterArray = $this->request->post('water');
       // $electricArray =  "[{\"id\":5,\"name\":\"A701\",\"lastMonth\":200,\"type\":\"normal\",\"nowMonth\":300,\"clear\":4,\"total\":100,\"multiple\":0},{\"id\":6,\"name\":\"A708\",\"lastMonth\":200,\"type\":\"multiple\",\"nowMonth\":299,\"clear\":4,\"total\":100,\"multiple\":1},{\"name\":\"a008\",\"lastMonth\":\"100\",\"nowMonth\":\"300\",\"total\":\"400.00\",\"type\":\"multiple\",\"multiple\":\"2\",\"clear\":\"4\"}]";
       // $hy_id = 2;
       // $waterArray =  "[{\"id\":3,\"name\":\"尘世中心\",\"lastMonth\":90,\"nowMonth\":50,\"clear\":4,\"total\":7},{\"id\":7,\"name\":\"A709\",\"lastMonth\":300,\"nowMonth\":1000,\"clear\":4,\"total\":1500},{\"name\":\"a009\",\"lastMonth\":\"200\",\"nowMonth\":\"300\",\"total\":\"100.00\",\"clear\":\"4\"}]";
        $electricArray = json_decode($electricArray,true);
        $waterArray = json_decode($waterArray,true);

        $waterInsertData = [];
        $electricInsertData = [];
        //公共数据
        $year = date('Y');
        $month =date('n');

        $date_time = date('Y-m-d H:i:s',time());
        //电费
        try {
            if(!empty($electricArray)){
                foreach($electricArray as $key=>&$v){
                        if(array_key_exists('id',$v)){
                            $upData = [
                                'title'=>$v['name'],
                                'last_month' => $v['lastMonth'],
                                'this_month' =>$v['nowMonth'],
                                'this_number'=>bcsub($v['nowMonth'],$v['lastMonth'],2),
                                'clear' => $v['clear'],
                                'multiple' =>$v['multiple'],
                                'money'  => $v['total'],
                                'type'=>1,
                                'update_time'=>$date_time
                            ];
                            $this->model->query()->where('id',$v['id'])->update($upData);
                        }else{
                            $electricInsertData[] = [
                                'shop_id' =>$hy_id,
                                'title'=>$v['name'],
                                'last_month' => $v['lastMonth'],
                                'this_month' =>$v['nowMonth'],
                                'this_number'=>bcsub($v['nowMonth'],$v['lastMonth'],2),
                                'clear' => $v['clear'],
                                'multiple' =>$v['multiple'],
                                'money'  => $v['total'],
                                'type'=>1,
                                'year' =>$year,
                                'month'=>$month,
                                'create_time' =>$date_time,
                                'update_time'=>$date_time
                            ];
                        }
                }

            }


            //水费
            if(!empty($waterArray)){
                foreach($waterArray as $key=>&$v){
                    if(array_key_exists('id',$v)){
                        $upData = [
                            'title'=>$v['name'],
                            'last_month' => $v['lastMonth'],
                            'this_month' =>$v['nowMonth'],
                            'this_number'=>bcsub($v['nowMonth'],$v['lastMonth'],2),
                            'clear' => $v['clear'],
                            'money'  => $v['total'],
                            'type'=>2,
                            'update_time'=>$date_time
                        ];
                        $this->model->query()->where('id',$v['id'])->update($upData);
                    }else{
                        $waterInsertData[] = [
                            'shop_id' =>$hy_id,
                            'title'=>$v['name'],
                            'last_month' => $v['lastMonth'],
                            'this_month' =>$v['nowMonth'],
                            'this_number'=>bcsub($v['nowMonth'],$v['lastMonth'],2),
                            'clear' => $v['clear'],
                            'money'  => $v['total'],
                            'type'=>2,
                            'year' =>$year,
                            'month'=>$month,
                            'create_time' =>$date_time,
                            'update_time'=>$date_time
                        ];
                    }
             }
            }

            if(!empty($waterInsertData)){
                $this->model->query()->insert($waterInsertData);

            }
            if(!empty($electricInsertData)){
                $this->model->query()->insert($electricInsertData);
            }
            return rjson(200,'保存成功');
        }catch (\Exception $e){
                return  rjson(0,$e->getMessage());
        }

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
                'a.shop_id','a.title','a.last_month','a.this_month','a.this_number','a.money','area.area_name',
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
                            $returnData[$time][$value->shop_id]['electricity_number'] = bcadd($returnData[$time][$value->shop_id]['electricity_number'],$value->this_number,0);
                            array_push($returnData[$time][$value->shop_id]['electricity'],[
                                "name"=>$value->title,
                               "lastMonth"=>$value->last_month,
                                "nowMonth"=>$value->this_month,
                                "total"=>bcadd($value->this_number,0,2)
                            ]);
                        }else{
                            $returnData[$time][$value->shop_id]['water_number'] = bcadd($returnData[$time][$value->shop_id]['water_number'],$value->this_number,0);
                            array_push($returnData[$time][$value->shop_id]['water'],[
                                "name"=>$value->title,
                                "lastMonth"=>$value->last_month,
                                "nowMonth"=>$value->this_month,
                                "total"=>bcadd($value->this_number,0,2)
                            ]);
                        }
                        continue;
                    }
                }
                /**
                 * 第一个数据的值作为公共值
                 */

                $returnData[$time][$value->shop_id]['area_name']  =$value->area_name;
                $returnData[$time][$value->shop_id]['mouth_name'] = $value->mouth_name;
                $returnData[$time][$value->shop_id]['time']  = $time;
                if($value->type == 1 ){
                    //合计
                    $returnData[$time][$value->shop_id]['electricity_number'] = $value->this_number; //电
                    $returnData[$time][$value->shop_id]['water_number'] = 0;//水
                    $returnData[$time][$value->shop_id]['electricity'][] = [
                        "name"=>$value->title,
                        "lastMonth"=>$value->last_month,
                        "nowMonth"=>$value->this_month,
                        "total"=>bcadd($value->this_number,0,2)
                    ];
                    $returnData[$time][$value->shop_id]['water'] = [];
                }else{
                    //合计
                    $returnData[$time][$value->shop_id]['water_number'] = $value->this_number;//水
                    $returnData[$time][$value->shop_id]['electricity_number'] = 0;//电
                    $returnData[$time][$value->shop_id]['water'][] = [
                        "name"=>$value->title,
                        "lastMonth"=>$value->last_month,
                        "nowMonth"=>$value->this_month,
                        "total"=>bcadd($value->this_number,0,2)
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

    public function del(){
        $hy_id = $this->request->post('id');
        if(empty($hy_id)){
            return rjson(0,'网络异常刷新重试');
        }
        $model = new HydropowerModel();
        $bool = $model->where('id',$hy_id)->update(['is_del'=>1]);
        if($bool){
            return rjson(200,'删除成功');
        }
        return rjson(0,'删除失败');
    }
}