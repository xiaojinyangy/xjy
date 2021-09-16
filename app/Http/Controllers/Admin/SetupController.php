<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\SystemModel;
use Illuminate\Http\Request;

class SetupController  extends  Controller
{
    protected $model;
    protected $request;
    public function  __construct(Request $request)
    {
        $this->model = new SystemModel();
        $this->request = $request;
    }
    /**
     * 图文 显示 和 修改
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function imageText(){
        if($this->request->method() == "POST"){
            $content = $this->request->post('content');
           $bool =  $this->model->query()->where(['key'=>'about'])->update(['value'=>$content]);
           if($bool){
               return rjson(200,'保存成功');
           }else{
               return rjson(0,'保存失败');
            }
        }
         $content =   $this->model->query()->where(['key'=>'about'])->value('value');
        return view('admin.system.text',compact('content'));
    }
    /**
     * 联系电话
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setPhone(){
        if($this->request->method() == "POST"){
            $phone = $this->request->post('phone');
            $bool =  $this->model->query()->where(['key'=>'phone'])->update(['value'=>$phone]);
            if($bool){
                return rjson(200,'保存成功');
            }else{
                return rjson(0,'保存失败');
            }
        }
        $phone =   $this->model->query()->where(['key'=>'phone'])->value('value');
        return view('admin.system.phone',compact('phone'));
    }
}