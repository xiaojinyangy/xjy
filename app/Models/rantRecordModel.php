<?php


namespace App\Models;


class rantRecordModel extends Base
{
    protected  $table = 'jh_rant_record';
    protected $primaryKey  = "id";
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

}