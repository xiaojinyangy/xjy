<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class usersController extends Controller
{
    protected $Model;
    protected $Request;
    public function __construct(Request $request)
    {
        $this->Request = $request;
        $this->Model = new User();
    }


    public function index(){
      if($this->Request->method() == "POST"){
            $where = [];
            $phone = $this->Request->input('phone');
            if(!empty($phone)){
                $where = ['phone'=>$phone];
            };
            $result = $this->Model->getUserAll(0,$where);
            if(!empty($result)){
                foreach($result['data'] as $key=>&$v){
                    $v['key'] =  $key+1;
                    $v['sex'] =  $v['sex'] == 1 ? "男" :"女";
                    if($v['identity'] == 1){
                        $v['identity'] = "员工";
                    }else if($v['identity'] == 2){
                        $v['identity'] = "店长";
                    }else{
                        $v['identity'] = "普通用户";
                    }
                    $v['regist_time'] = date('Y-m-d H:i:s',$v['regist_time']);
                    $v['headpic'] = "<img src=$v[headpic] width='80px' height='60'>";
                }
            }
            return rjson(0,'加载成功',$result);
      }
      return view('users.index');
    }

    public function Info(){
        $id = $this->Request->input('id');
        if(empty($id))return rjson(0,'网络异常');
        $result = $this->Model->getUserAll($id);
        return view('users.info',['result'=>$result]);
    }

    public function del(){
        $id = $this->Request->input('id');
        if(empty($id))return rjson(0,'网络异常');
        $bool = $this->Model->query()->where(['user_id'=>$id])->update(['is_del'=>1]);
        if($bool){
            return rjson(200,'删除成功');
        }
        return rjson(200,'删除失败');
    }




}