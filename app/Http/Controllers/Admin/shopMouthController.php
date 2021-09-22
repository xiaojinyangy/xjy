<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\AreaModel;
use App\Models\ShopMouthModel;
use Illuminate\Http\Request;

class shopMouthController extends Controller
{
    protected $Model;
    protected $Request;
    protected $area_list;
    public function __construct(Request $request)
    {
        $this->Request = $request;
        $this->Model = new ShopMouthModel();
        $area_model  = new AreaModel();
        $this->area_list = $area_model->index();//区域列表
    }

    /**
     * 首页查询 数据和页面
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        if($this->Request->method() == "POST") {
            $where = ['jh_shop_mouth.is_del'=>0,'jh_shop_mouth.status'=>1];
            $search_data = $this->Request->post('form');
          if(!empty($search_data)){
              $search_data = Ajax_Arr($search_data);
              if(isset($search_data['mouth_name'])) $where['mouth_name'] = $search_data['mouth_name'];
              if(isset($search_data['area_id'])){
                  $where['jh_shop_mouth.area_id'] = $search_data['area_id'];
              }
          }
            $result  =  $this->Model->area_mouth($where);
            if(!empty($result['data'])){
                foreach($result['data'] as $key=>&$value){
                    $value['key'] = $key+1;
                }
            }
            return ['code'=>0,'msg'=>'成功','data'=>$result];
        }
        $area_list= $this->area_list;
        return view('admin.shop_mouth.index',compact('area_list'));
    }

    /**
     * 添加 页面和提交
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        if($this->Request->method() == "POST") {
            $form = $this->Request->post('data');
            $data = Ajax_Arr($form);
            if(!array_key_exists('area_id',$data) && empty($data['area_id'])){
                return rjson(0,'请选择区域名称');
            }
            if(!array_key_exists('mouth_name',$data) && empty($data['mouth_name'])){
                return rjson(0,'请填写档口名称');
            }
            $form['sort'] = isset( $data['sort']) ?  $data['sort'] : 0;
            $judge = $this->Model->index(['mouth_name' => $data['mouth_name'],'area_id'=>$data['area_id']]);
            if(!empty($judge['data'])){
                return rjson(0,'该区域已存在该档口');
            }
            $bool =  $this->Model->add($data);
            if($bool){
                return rjson(200,'添加成功');
            }
            return rjson(0,'修改失败');
        }
        $area_list= $this->area_list;
        return view('admin.shop_mouth.add',compact('area_list'));
    }

    /**
     * 编辑页面和提交
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function set(){
        if($this->Request->method() == "POST") {
            $id =  $this->Request->post('id');
            if(empty($id)) return rjson(0,'网络异常请稍后再试');
            $area_id =  $this->Request->post('area_id');
            $name =  $this->Request->post('mouth_name');
            $sort = $this->Request->post('sort');
           if(empty($name)) return rjson(0,'请填写档口名称');
            $sort = isset($sort) ? $sort : 0;
            $judge = $this->Model->index(['mouth_name' => $name,'area_id'=>$area_id]);
            if(!empty($judge['data'])){
                return rjson(0,'该区域已存在该档口');
            }
            $bool =  $this->Model->set(['id'=>$id],['mouth_name'=>$name,'sort'=>$sort,'area_id'=>$area_id]);
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
        $area_list= $this->area_list;
        return view('admin.shop_mouth.set',compact('result','id','area_list'));
    }

    /**
     * 删除
     * @return array
     */
    public function del(){
        $id =  $this->Request->post('id');
        if(empty($id)) return rjson(0,'网络异常请稍后再试');
        $bool =  $this->Model->set(['id'=>$id],['is_del'=>1]);
        if($bool){
            return rjson(200,'删除成功');
        }
        return rjson(0,'删除失败');
    }


    public function area_mouth(){
        $area_id = $this->Request->get('area_id');
        return $this->Model->index(['area_id'=>$area_id]);
    }
}