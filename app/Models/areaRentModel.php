<?php


namespace App\Models;


class areaRentModel extends Base
{
    protected  $table = "jh_area_rent";
    protected  $primaryKey = 'id';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
}