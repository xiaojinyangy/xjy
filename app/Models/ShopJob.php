<?php


namespace App\Models;


class ShopJob extends Base
{
    protected $table = "jh_shop_job";
    protected $primaryKey = 'id';
    const CREATED_AT =  "create_time";
    const UPDATED_AT = "update_time";


    public function job()
    {
        return $this->hasOne(JobModel::class,'id','job_id');
    }
    public function user(){
        return $this->hasOne(User::class,'user_id','user_id');
    }
    public function shop(){
        return $this->hasOne(Shop::class,'id','shop_id');
    }
}