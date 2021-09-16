<?php


namespace App\Models;


class MessageModel extends Base
{
    protected  $primaryKey = "id";
    protected $table = "jh_message";
    const CREATED_AT = "create_time";
    const UPDATED_AT = "update_time";
}