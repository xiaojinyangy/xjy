<?php


namespace App\Models;


class SystemModel extends Base
{
  protected $table = "jh_system";
  protected $primaryKey = 'id';
  const CREATED_AT = "create_time";
  const UPDATED_AT = "update_time";

}