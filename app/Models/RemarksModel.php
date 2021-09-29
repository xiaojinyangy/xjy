<?php


namespace App\Models;


class RemarksModel extends Base
{
    protected  $table = "jh_remarks";
    protected  $primaryKey = 'id';
    const CREATED_AT = "create_time";
    const UPDATED_AT = 'update_time';

    /**
     * 查看自己的备注
     * @param $where
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function viewMyRemarks($where){
        $data = $this->query()->where($where)
            ->orderBy('id','desc')
            ->select(['id','title','remarks','create_time'])->paginate();
        $data =  getPaginateData($data);
        return $data;
    }
}