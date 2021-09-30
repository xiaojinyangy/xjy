<?php


namespace App\Models;


class RecordJobModel extends Base
{
    protected  $table = "jh_hydropower_job";
    protected  $primaryKey = 'id';
    const CREATED_AT = "create_time";
    const UPDATED_AT = 'update_time';

    public  function index($where=[],$state=1){
        if($state == 1 ){
            $result =  $this->query()->where($where)->orderBy('id','desc')->paginate();
            $result = getPaginateData($result);
        }else{
            $result =  $this->query()->where($where)->first();
        }
        return $result;
    }

    public function add($data){
        return $this->query()->insert($data);
    }
}