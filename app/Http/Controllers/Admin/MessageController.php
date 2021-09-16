<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\MessageModel;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $model;
    protected $request;
    public function  __construct(Request $request)
    {
        $this->model = new MessageModel();
        $this->request = $request;
    }

    public function index(){
        if($this->request->method() =="POST"){
           $result =  $this->model->query()->orderBy('sort','desc')->paginate();
           $result  =   getPaginateData($result);
           if(!empty($result['data'])){
               foreach($result['data'] as $key=>$v){
                   $result['data'][$key]['key'] = $key+1;
               }
           }
           return rjson(0,'加载成功',$result);
        }
        return view('admin.message.index');
    }

    public function add(){
        if($this->request->method() =="POST"){
            $message = $this->request->post('message');
            if(empty($message)){
                return rjson(0,'请填写消息');
            }
            $sort = $this->request->post('sort');
            $data = [
                "message" => $message,
                "goto_user" => "全体用户",
                "create_time"=> date('Y-m-d H:i:s'),
                'sort' => $sort
            ];
            $bool = $this->model->query()->insert($data);
            if($bool){
                return rjson(200,'发送成功');
            }
            return rjson(0,'发送失败');
        }
        return view('admin.message.add');
    }

    public function del(){
        $id = $this->request->post('id');
        $bool = $this->model->query()->where(['id'=>$id])->delete();
        if($bool){
            return rjson(200,'删除成功');
        }
        return rjson(0,'删除失败');
    }
}