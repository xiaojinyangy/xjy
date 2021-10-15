<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\AreaModel;
use App\Models\JobModel;
use App\Models\ShopJob;
use App\Models\ShopMouthModel;
use Illuminate\Http\Request;

class JobController extends Controller
{
    protected  $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function areaMouth(){
        $model = new AreaModel();
        $mouthModel = new ShopMouthModel();
       $code =  $this->request->post('code')
       $areaData =  $model->query()->where(['status'=>1],2)->select(['id','area_name'])->get()->toArray();
       if($code == 1){
                return rjson(200,'请求成功',$areaData);
       }
       $mouthData =  $mouthModel->query()->select(['id','mouth_name','area_id'])->where(['is_del'=>0,'status'=>1])->get()->toArray();
       if( !empty($areaData) &&  !empty($mouthData)){
           foreach($areaData as $key=>$v){
               foreach ($mouthData as $value){
                   if($v['id'] == $value['area_id']){
                       $areaData[$key]['child'][] = $value;
                   }
               }
           }
       }
       return rjson(200,'加载成功',$areaData);
    }

    /**
     * 申请商铺
     * @return array
     */
    public function Apply(){
        $user_id = $this->request->get('id');
        $data = $this->request->post('.post');
        $data['user_id'] = $user_id;
        $job_model =new JobModel();
        $job_id = $job_model->query()->where(['user_id'=>$user_id])->value('id');
        $model = new ShopJob();
        $check = $model->query()->where(['user_id'=>$user_id,'job_id'=>$job_id])->first();
        if(!empty($check)){
            if($check->status == 1) {
                return  rjson(200,'已是该商铺的员工');
            }else if($check->status == 0){
                return  rjson(200,'待审核中请稍后');
            }
        }
        $data['job_id'] = $job_id;
        $judge = $model->add($data);
        if($judge){
          return   rjson(200,'申请成功');
        }
        return   rjson(200,'申请失败');
    }

    /**
     * 员工的 商品
     * @return array
     */
    public function job_shop(){
        $user_id = $this->request->get('id');
        $test = $this->request->post('state');
        $user_id = 1000;

        $job_model  = new JobModel();

        $shop_job_model = new ShopJob();
        $job_data =  $job_model->query()->where(['user_id'=>$user_id])->first();
        if(empty($job_data)){
            return rjson(0,'未成为员工');
        }
        $result = $shop_job_model->query()->from('jh_shop_job as a')
            ->leftJoin('jh_user_shop as b','b.id','a.shop_id')
            ->leftJoin('jh_shop_mouth as c','c.id','b.mouth_id')
            ->leftJoin('jh_area as p','p.id','b.area_id')
            ->where(['a.user_id'=>$user_id,'a.job_id'=>$job_data->id])
            ->select(['p.area_name','c.mouth_name','a.job_id','b.name','a.status'])
            ->paginate();
        $result = getPaginateData($result);
        $list = $result['data'];
        unset($result['data']);
        $return_data = [
            'name'=>isset($job_data->name) ? $job_data->name : '',
            'phone'=>isset($job_data->phone) ? $job_data->phone : '',
            'shop_number' => $result['total'],
            'list' =>$list
        ];
        return rjson(200,'加载成功',$return_data);

    }
}