<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\ImageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ImageController extends Controller
{
    protected  $model;
    protected $Request;
    public function __construct(Request $request)
    {
        $this->model = new ImageModel();
        $this->Request = $request;
    }

    public function index(){
        if($this->Request->method() == "POST"){
            $result = $this->model->index('admin');
            if(!empty($result['data'])){
                foreach($result['data'] as $key=>&$value){
                    $value['key'] = $key+1;
                    $value['file_path'] ="<img src=" . config('appConfig.url_http').$value['file_path'] . ">";
                }
            }
            return rjson(0,'加载成功',$result);
        }
        return view('admin.home.image');
    }

    public function add(){
        if($this->Request->method() == "POST"){
            $data = $this->Request->post('data');//图片id
            $data = Ajax_Arr($data);
            $data['create_time'] =  date('Y-m-d H:i:s');
            $bool =  $this->model->insert($data);
            if($bool){
                return rjson(200,'添加成功');
            }
            return rjson(200,'添加失败');
        }
        return view('admin.home.add');
    }

    public function set(){
        $home_image_id = $this->Request->input('id'); //轮播图id
        if($this->Request->method() == "POST"){
            $data = $this->Request->post('data');//图片id
            $data = Ajax_Arr($data);
            $data['update_time'] =  date('Y-m-d H:i:s');
            $bool =  $this->model->where(['id'=>$home_image_id])->update($data);
            if($bool){
                return rjson(200,'修改成功');
            }
            return rjson(0,'修改失败');
        }
        $data = $this->model->index('set',['home.id'=>$home_image_id]);
        $data['file_path'] = config('appConfig.url_http').$data['file_path'];
        return view('admin.home.set',compact('data','home_image_id'));
    }

    public function del(){
        $home_image_id = $this->Request->post('image_id'); //轮播图id
       $bool =  $this->model->del(['id'=>$home_image_id]);
       if($bool){
           return rjson(200,'删除成功');
       }
        return rjson(0,'删除失败');
    }
}