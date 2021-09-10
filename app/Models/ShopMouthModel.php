<?php


namespace App\Models;


class ShopMouthModel extends Base
{
    protected  $table = "jh_shop_mouth";
    protected $primaryKey  = "id";
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';


    /**
     * 查询全部数据
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function index($where=['is_del'=>0,'status'=>1]){
        $result =  $this->query()->where($where)->select()->paginate();
        return getPaginateData($result);
    }

    /**
     * 添加数据
     * @param $data 添加的数据
     * @return bool
     */
    public function addData($data)
    {
        return $this->query()->insertGetId($data);
    }

    /**
     * 修改
     * @param array $where
     * @param array $data
     * @return int
     */
    public function set($where,$data=[]){
        return  $this->query()->where($where)->update($data);
    }

    /**
     * 删除
     * @param $where
     * @return Base|bool
     */
    public function del($where){
        return  $this->query()->where($where)->delete();
    }

    /**
     *
     */
    public function  area_mouth($where=['jh_shop_mouth.is_del'=>0,'jh_shop_mouth.status'=>1]){
        $result = $this->query()
            ->rightJoin('jh_area','jh_area.id','=','jh_shop_mouth.area_id')
            ->where($where)
            ->select(['jh_area.area_name','jh_shop_mouth.*'])->paginate();
        return getPaginateData($result);
    }
}