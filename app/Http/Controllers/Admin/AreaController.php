<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\AreaModel;
use Illuminate\Http\Request;


class AreaController extends Controller
{
    protected $Model;
    protected $Request;
    public function __construct(Request $request)
    {
        $this->Request = $request;
        $this->Model = new AreaModel();
    }

    public function index(){
          if($this->Request->method() == "POST") {
              $result  =  $this->Model->index([]);
//
              if(!empty($result['data'])){
                  foreach($result['data'] as $key=>&$value){
                      $value['key'] = $key+1;
                  }
              }
              return ['code'=>0,'msg'=>'成功','count'=>$result['total'],'data'=>$result['data']];
          }
        return view('admin.area.index');
    }


    public function add(){
        if($this->Request->method() == "POST") {
            $form = $this->Request->post('data');
            $data = Ajax_Arr($form);
            if(!array_key_exists('area_name',$data) && empty($data['area_name'])){
                return rjson(0,'请填写区域名称');
            }
            $form['sort'] = isset( $data['sort']) ?  $data['sort'] : 0;
            $judge = $this->Model->index(['area_name'=>$data['area_name']]);
            if(!empty($judge['data'])){
                return  rjson(0,'区域已存在');
            }
            $bool =  $this->Model->add($data);
            if($bool){
                return rjson(200,'添加成功');
            }
            return rjson(0,'修改失败');
        }
        return view('admin.area.add');
    }

    public function set(){
        if($this->Request->method() == "POST") {
            $id =  $this->Request->post('id');
            if(empty($id)) return rjson(0,'网络异常请稍后再试');
            $name =  $this->Request->post('area_name');
            $sort = $this->Request->post('sort');
            if(empty($name)) return rjson(0,'请填写区域名称');
            $sort = isset($sort) ? $sort : 0;
            $judge = $this->Model->index(['area_name'=>$name]);
            if(!empty($judge['data'])){
              return  rjson(0,'区域已存在');
            }
            $bool =  $this->Model->set(['id'=>$id],['area_name'=>$name,'sort'=>$sort]);
            if($bool){
                return rjson(200,'修改成功');
            }
            return rjson(0,'修改失败');
        }
        $id =  $this->Request->post('id');
        $result =  $this->Model->index(['id'=>$id]);
        if(!empty($result)){
            $result = $result['data'][0];
            $result['sort'] = intval($result['sort']);
        }
        return view('admin.area.set',compact('result','id'));
    }

    public function del(){
        $id =  $this->Request->post('id');
        if(empty($id)) return rjson(0,'网络异常请稍后再试');
        $bool =  $this->Model->del(['id'=>$id]);
        if($bool){
            return rjson(200,'删除成功');
        }
        return rjson(0,'删除失败');
    }
}