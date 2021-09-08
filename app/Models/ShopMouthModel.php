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
    public function index($where=['status'=>1]){
        return $this->query()->where($where)->select()->paginate();
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
}