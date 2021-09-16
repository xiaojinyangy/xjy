<?php


namespace App\Models;


class ImageModel extends Base
{
 protected  $primaryKey = 'id';
 protected $table = 'jh_home_image';
 const CREATED_AT = 'create_time';
 const UPDATED_AT = 'create_time';

     public function file(){
            return $this->hasOne(UpImageModel::class,'image','id');
     }

     public function index($state="admin",$where=[]){
         $result = $this->query()->from('jh_home_image as home')
             ->leftJoin('jh_up_image as image','image.id','home.image_id')
             ->orderBy('sort','desc')
             ->where($where)
             ->select(['image.file_path','home.id','home.sort','home.image_id']);
             if($state == "admin"){
                 $result = $result->paginate();
                 $result = getPaginateData($result);
             }else if($state == "api"){
                 $result = $result->get();
             }else if($state == "set"){
                 $result = $result->first();
             }
        return $result;
     }

}