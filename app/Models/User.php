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
}
