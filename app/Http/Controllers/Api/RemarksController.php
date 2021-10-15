<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\RemarksModel;
use Illuminate\Http\Request;

class RemarksController extends Controller
{
    protected  $request;
    protected $model;
    protected $user_id;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->model = new RemarksModel();
        $this->user_id = $request->get('id');
    }

    /**
     * 显示我的备注
     * @return array
     */
    public function view(){

        $data =  $this->model->viewMyRemarks(['id'=>$this->user_id]);
        return rjson(200,'加载成功',$data);
    }

    public function addRemarks(){
        $user_id = $this->request->get('id');
        $remarks = $this->request->post('remarks');
        $title = $this->request->post('title');
        if(empty($title)) rjson(0,'请填写备注标题');
        if(empty($remarks)) rjson(0,'请填写备注');
        $judge = $this->model->add(['remarks'=>$remarks,'title'=>$title,'user_id'=>$user_id]);
        if($judge){
            return rjson(200,'添加成功');
        }
        return rjson(0,'添加失败');
    }

    public function update(){
        $user_id = $this->request->get('id');
        $id = $this->request->post('remarks_id');
        $title = $this->request->post('title');
        if(empty($title)) rjson(0,'请填写备注标题');
        $remarks = $this->request->post('remarks');
        if(empty($remarks)) rjson(0,'请填写备注');
        $judge = $this->model->edit(['id'=>$id,'user_id'=>$user_id],['remarks'=>$remarks,'title'=>$title]);


        if($judge){
            return rjson(200,'修改成功');
        }
        return rjson(0,'修改失败');
    }

    public function delRemarks(){
        $id = $this->request->post('remarks_id');
        $judge = $this->model->del(['id'=>$id]);
        if($judge){
            return rjson(200,'删除成功');
        }
        return rjson(0,'删除失败');
    }
}