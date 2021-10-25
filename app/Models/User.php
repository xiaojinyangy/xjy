<?php

namespace App\Models;

class User extends Base
{   
    //指定主键
    protected  $table = "jh_users";
    protected $primaryKey = 'user_id';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    public function getUserAll($user_id =0,$where=[],$field="*",$with=[],$page=15,$order=['user_id','desc'],$group=""){
        $where['is_del'] = 0;
        $model = $this->query()->where($where)->select($field)->orderBy($order[0],$order[1]);
        if(!empty($with)){
            $model->with($with);
        }

        if($user_id === 0){
            $result  = $model->paginate();
            $result = getPaginateData($result);
        }else{
            $result  = $model->find($user_id);
        }
        return $result;
    }

    public function userIdentity($user_id){
        $identity = $this->query()->where('user_id',$user_id)->value('identity');
        $jobModel = new JobModel();
        $shopJobModel = new ShopJob();
        if($identity == 1 ){ //员工

            $jobInfo = $jobModel->where('user_id',$user_id)->select('id')->frist();;
            $shopIdObj =  $shopJobModel->query()->where(['job_id'=>$jobInfo->id])->select('shop_id')->get();
        }else if($identity == 2 ){//店长
            $shopIdObj =   $shopJobModel->query()->where('user_id',$user_id)->select('shop_id')->get();
        }
        return $shopIdObj;
    }


    public function areaMonth($shop_id){
        $result  = $this->query()
            ->from('jh_user_shop as shop')
            ->leftJoin('jh_area as area','area.id','=','shop.area_id')
            ->leftJoin('jh_shop_mouth as shop_mouth','shop_mouth.id',"=","shop.mouth_id")
            ->select(['area.area_name','shop_mouth.mouth_name'])
            ->where(['shop.id'=>$shop_id])
            ->orderBy('shop.id','desc')->first();
        if(!empty($result)){
            return [
                $result->area_name,$result->mouth_name
            ];
        }
        return false;
    }
}
