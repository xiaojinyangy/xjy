<?php


namespace App\Models;


use function foo\func;

class Shop extends Base
{
    protected $table = "jh_user_shop";
    protected $primaryKey = 'id';
    const CREATED_AT =  "create_time";
    const UPDATED_AT = "update_time";


    public function index($where=[],$state= 1,$ext_where=[]){
        $where['shop.is_del'] = 0;
        $Year =date('Y');
        $month = date('n');
        $model = $this->query()
            ->from('jh_user_shop as shop')
            ->with(['rant'=>function ($query)use($Year,$month){
                $query->select(['id','shop_id','title','last_month','this_month','this_number','money','type','clear','multiple'])->where(['year'=>$Year,'status'=>0,'is_del'=>0]);
            }])
            ->leftJoin('jh_area as area','area.id','=','shop.area')
            ->leftJoin('jh_shop_mouth as shop_mouth','shop_mouth.id',"=","shop.mouth")
            ->select(['shop.*','area.area_name','shop_mouth.mouth_name'])
            ->where($where)
            ->orderBy('shop.id','desc');
        if(array_key_exists('notin',$ext_where)){
            $model = $model->whereIn($ext_where['notin'][0],$ext_where['notin'][1]);
        }

        //$with = ["area" => function($query){$query->select(['id','area_name']);},
//            "mouth"=>function($query){
//                $query->select(['id',"mouth_name"]);
//            }];
        if($state == 1 ){
            $result = $model->get();
          //  $result  =  getPaginateData($result);
        }else{
            $result = $model->first();
        }
        return $result;
    }

    /**
     * 获取自己的商铺
     * @param $shop_id
     */
    public function getMyShop($user_id){
        $shopData = $this->query()->where('user_id',$user_id)->get();
        if(!empty($shopData)){
             return $shopData->toArray();
        }else{
            return [];
        }
    }
    public function shopRant($shop_id){

    }
    //用户
    public function user(){
       return $this->hasOne(User::class,'user_id','user_id');
    }
    //区域
    public function areas(){
        return $this->hasOne(AreaModel::class,'id','area');
    }
    //档口
    public function mouths(){
        return $this->hasOne(ShopMouthModel::class,'id','mouth');
    }
    public function job(){
        return $this->hasMany(ShopJob::class,'shop_id','id');
    }
    public function rant(){
        return $this->hasMany(HydropowerModel::class,'shop_id','id');
    }
    public function areaRant(){
        return $this->hasMany(areaRentModel::class,'area','area_id');
    }

}