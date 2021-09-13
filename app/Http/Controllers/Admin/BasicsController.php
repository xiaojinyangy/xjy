<?php


namespace App\Http\Controllers\Admin;


use App\Models\areaRentModel;
use Illuminate\Http\Request;

class BasicsController
{
    protected  $model;
    public function __construct(Request $request)
    {
        $this->model = new areaRentModel();
        $this->Request = $request;
    }

    public function index(){
       $result = $this->model->query()->where(['is_del'=>0])->orderBy('id','desc')->first(1);
      if($this->Request->method() == "post"){
          $data = $this->Request->post('data');
          $data =  Ajax_Arr($data);
          foreach($data as $key=>$v){
              if($result->$key != $v){
                $bool =   $this->model->query()->insert($data);
                if($bool){
                    return rjson(200,'修改成功');
                }else{
                    return rjson(0,'修改失败');
                }
              }
          }
      }
      return view('admin.basics.index');
    }
}