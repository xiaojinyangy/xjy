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


    public function getPayMsgNumber($user_id){
        $pay_rant_msg_number = "";
        /**缴费订单信息*/
        if(!empty($user_id)) {
            $userModel = new User();
            $shopObj = $userModel->userIdentity($user_id);

            if (!empty($shopObj)) {
                $shopArr = $shopObj->toArray();
            }
            $pay_rant_msg_number = $this->query()->whereIN('shop_id',$shopArr)->where(['is_del' => 0])->count();
        }
        return $pay_rant_msg_number;
    }
}