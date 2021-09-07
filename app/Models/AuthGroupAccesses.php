<?php

namespace App\Models;

class AuthGroupAccesses extends Base
{   
	//指定主键
    protected $table = 'jh_auth_group_accesses';
    protected $primaryKey = 'accesses_id';
    //管理员关联 hasOne('关联模型','关联模型关联id','本模型的关联id');
    public function admin()
    {
    	return $this->hasOne('App\Models\Admin','admin_id','admin_id')->select(['admin_id','admin_name','admin_img']);
    }
    
    //管理组关联
    public function group()
    {
    	return $this->hasOne('App\Models\AuthGroup','group_id','group_id')->select(['group_id','group_name']);
    }

    
}
