<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\AreaModel;
use App\Models\Shop;
use App\Models\ShopMouthModel;
use Illuminate\Http\Request;

class UserShopController extends  Controller
{
    protected $Model;
    protected $Request;
    public function __construct(Request $request)
    {
        $this->Request = $request;
        $this->Model = new Shop(); //员工
    }

    public function index(){
        if($this->Request->method() == "POST"){
            $where= [];
            $area_id = $this->Request->post('area');
            if(!empty($area_id)){
                $where['shop.area_id'] = $area_id;
            }
            $month_id = $this->Request->post('month');
            if(!empty($month_id)){
                $where['shop.month_id'] = $area_id;
            }
            $result =  $this->Model->index($where);
            if(!empty($result['data'])){
                foreach($result['data'] as $key=>$value){
                    $result['data'][$key]['key'] = $key+1;
                    $result['data'][$key]['sex'] =  $result['data'][$key]['sex'] == 1 ? "男" : "女";
                    $image = $result['data'][$key]['id_no_image'];
                    $result['data'][$key]['id_no_image'] =  "<img src=$image width='100ox' height='100px'>";
                }
            }
            return rjson(0,'加载成功',$result);
        }
        return view('admin/shop/index');
    }

    public function set(){
       $id =  $this->Request->post('id');
       $id =  $this->Request->post('id');
        if(empty($id))return rjson(0,'网络异常,请刷新重试');
        if($this->Request->method() == "POST"){
            $data = $this->Request->post('');
            $bool = $this->Model->where(['id'=>$id])->update($data);
            if($bool){
                return rjson(200,'修改成功');
            }
            return rjson(0,'修改失败');

        }
       $result =  $this->Model->index(['id',$id]);
        $area_model = new AreaModel();
        $area_list = $area_model->index()['data'];
        $mouth_model = new ShopMouthModel();
        $mouth_list = $area_model->index()['data'];
        return view('admin/shop/set',compact('result','area_list','mouth_list'));
    }

    public function del(){
        $id =  $this->Request->post('id');
        if(empty($id))return rjson(0,'网络异常,请刷新重试');
        $bool = $this->Model->query()->where('id',$id)->update(['is_del'=>1]);
        if($bool){
            return rjson(200,'删除成功');
        }
        return rjson(0,'删除失败');
    }
}