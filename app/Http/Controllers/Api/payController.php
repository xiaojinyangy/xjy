<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\JobModel;
use App\Models\ShopJob;
use App\Models\shopPayRant;
use App\Models\User;
use Illuminate\Http\Request;

class payController extends Controller
{
    public function payList(Request $request){
        $user_id = $request->get('id');
        $user_id = 1000;
        $pay_status = $request->post('pay_status');
        $UserModel = new User();
        $identity = $UserModel->query()->where(['user_id'=>$user_id])->value('identity');
        /**
         * 区域档口
         */
        $jobModel = new JobModel();
        $shopJobModel = new ShopJob();
        if($identity == 1 ){ //员工

            $jobInfo = $jobModel->where('user_id',$user_id)->select('id')->first();

           $shopIdObj =  $shopJobModel->query()->where(['job_id'=>$jobInfo->id])->select('shop_id')->get();
        }else if($identity == 2 ){//店长
            $shopIdObj =   $shopJobModel->query()->where('user_id',$user_id)->select('shop_id')->get();
        }
        $shopIdArr = [];
        if(!empty($shopIdObj)) {
            foreach ($shopIdObj as $v) {
                $shopIdArr[] = $v->shop_id;
            }
        }
        $start_date = $request->post('start');
        $end_date =  $request->post('end');
        $shopPayRantModel = new shopPayRant();
        if(empty($start_date) ){
            $start_date = [date('Y')-1,date('Y')];

            //var_dump(date('Y-h-m',strtotime('first day of year')));
            $end_date = ['1',date('n')];
        }else{
            $start_date_arr = implode('-',$start_date);
            $end_date_arr = implode('-',$end_date);
            $start_date = [$start_date_arr[0],$end_date_arr[0]];
            $end_date = [$start_date_arr[1],$end_date_arr[2]];
        }

        $model =  $shopPayRantModel->query()->where(['is_del'=>0,'pay_status'=>$pay_status])->whereIn('id',$shopIdArr)
            ->with(['shop','rant_ext','waterElectricRant']);
            if(!empty($start_date) && !empty($end_date)){
               $model =  $model->whereBetween('year',$start_date)->whereBetween('month',$end_date);
            }
            $result = [];
            foreach($model as $key=>$value){
                $result['year'] =$value['year'];//年
                $result['month'] =$value['month'];//月
                $result['rant_ext_money'] = $value['rant_ext']['rant_money'];//附加费
                /**
                 * 水电费处理
                 */
                if(!empty($value['water_electric_rant'])){
                    foreach($value['water_electric_rant'] as $key=>$v){

                    }
                }else{

                }

            }

           $result =  $model->paginate();
         return $result->toArray();
        }


        public function payMsg(){

        }
    }
