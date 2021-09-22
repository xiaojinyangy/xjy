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
            $search =  $this->Request->post('form');
            $search = Ajax_Arr($search);
            if(isset($search['area_id'])){

                $where['shop.area_id'] = $search['area_id'];
            }
            if(isset($search['mouth_name'])){
                $where['shop_mouth.mouth_name'] = $search['mouth_name'];
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
        $area_model = new AreaModel();
        $area_list = $area_model->index();
        return view('admin/shop/index',compact('area_list'));
    }

    public function set(){
       $id =  $this->Request->post('id');
        if(empty($id))return rjson(0,'网络异常,请刷新重试');
        if($this->Request->method() == "POST"){
            $data = $this->Request->post('data');
            $data =   Ajax_Arr($data);
            $bool = $this->Model->where(['id'=>$id])->update($data);
            if($bool){
                return rjson(200,'修改成功');
            }
            return rjson(0,'修改失败');

        }
       $result =  $this->Model->index(['id',$id],2);
        $area_model = new AreaModel();
        $area_list = $area_model->index()['data'];
        $mouth_model = new ShopMouthModel();
        $mouth_list = $mouth_model->index(['area_id'=>$result['area_id']])['data'];
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

    public function getUserShop(){
        $id =  $this->Request->post('id');
        if(empty($id))return rjson(0,'网络异常,请刷新重试');
        if($this->Request->method() == "POST"){
            $shop_model = new Shop();
            $area_id = $this->Request->post('area_id');
            $mouth_id = $this->Request->post('mouth_id');
            $where= ['shop.user_id' => $id];
            if(!empty($area_id)){
                $where['shop.area_id'] = $area_id;
            }
            if(empty($mouth_id)){
                $where['shop.mouth_id'] = $mouth_id;
            }
            $data =  $shop_model->index($where);
            foreach($data['data'] as $key=>&$v){
                $v['key'] = $key+1;
               if( $v['status'] == 0){
                   $v['status'] = "待审核";
               }else if($v['status'] == 1 ){
                   $v['status'] = "通过";
               }else{
                   $v['status'] = "拒绝";
               }
            }
            return rjson(0,"加载成功",$data);
        }
        $area_model = new AreaModel();
        $area_list = $area_model->index();
        return view('users.user_shop',compact('area_list','id'));
    }

}