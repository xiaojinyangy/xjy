<?php


namespace App\Models;


use function foo\func;

class Shop extends Base
{
    protected $table = "jh_user_shop";
    protected $primaryKey = 'id';
    const CREATED_AT =  "create_time";
    const UPDATED_AT = "update_time";


    public function index($where=[],$state= 1){
        $where['shop.is_del'] = 0;
        $model = $this->query()
            ->from('jh_user_shop as shop')
            ->leftJoin('jh_area as area','area.id','=','shop.area_id')
            ->leftJoin('jh_shop_mouth as shop_mouth','shop_mouth.id',"=","mouth_id")
            ->select(['shop.*','area.area_name','shop_mouth.mouth_name'])
            ->where($where)
            ->orderBy('shop.id','desc');
        //$with = [            "area" => function($query){$query->select(['id','area_name']);},
//            "mouth"=>function($query){
//                $query->select(['id',"mouth_name"]);
//            }];
        if($state == 1 ){
            $result = $model->paginate();
            $result  =  getPaginateData($result);
        }else{
            $result = $model->first();
        }
        return $result;
    }
    //用户
    public function user(){
       return $this->hasOne(User::class,'user_id','user_id');
    }
    //区域
    public function area(){
        return $this->hasOne(AreaModel::class,'id','area_id');
    }
    //档口
    public function mouth(){
        return $this->hasOne(ShopMouthModel::class,'id','mouth_id');
    }
    public function job(){
        return $this->hasMany(ShopJob::class,'shop_id','id');
    }
}