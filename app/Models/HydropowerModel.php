<?php


namespace App\Models;

class HydropowerModel extends Base
{

    protected $table = "jh_warte_electric_rant";
    protected $primaryKey = 'id';
    const CREATED_AT = "create_time";
    const UPDATED_AT = "update_time";
}