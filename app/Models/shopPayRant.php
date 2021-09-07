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
        $this->hasOne()
    }
}