<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class shopPayRant extends  Base
{
    protected  $table = "jh_shop_pay_rant";
    protected $primaryKey  = "id";
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    public function  user(){
      return  $this->hasOne(User::class,'id','user_id');
    }

    public  function  shop(){
        return  $this->hasOne(Shop::class,'shop_id','id');
    }
    public function rant_ext(){
        return $this->hasOne(areaRantExtModel::class,'id','area_rant_ext_id');
    }
    public function waterElectricRant(){
        return $this->hasOne(HydropowerModel::class,'shop_id','shop_id');
    }

}