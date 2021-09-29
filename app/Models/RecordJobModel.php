<?php


namespace App\Models;


class RecordJobModel extends Base
{
    protected  $table = "jh_hydropower_job";
    protected  $primaryKey = 'id';
    const CREATED_AT = "create_time";
    const UPDATED_AT = 'update_time';


}