<?php


namespace App\Http\Controllers\Admin;


use App\Models\AreaModel;
use App\Models\areaRantExtModel;
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
        $id = $this->Request->post('id');
        $result = $this->model->query()->where(['is_del'=>0,'id'=>$id])->orderBy('id','desc')->first();
      if($this->Request->method() == "POST"){
          $data = $this->Request->post('data');
          $data =  Ajax_Arr($data);
          $data['create_time'] = date('Y-m-d H:i:s');
          $data['update_time'] = date('Y-m-d H:i:s');
          if($result->area_id != $data['area_id']){
              $check = $this->model->query()->where('area_id',$data['area_id'])->first();
              if(!empty($check)) return rjson(0,'该区域已存在设置');
          }
          foreach($data as $key=>$v){
              if($result->$key != $v){
                $bool =   $this->model->query()->insertGetId($data);
                if($bool){
                    $this->model->query()->where(['id'=>$result->id,'is_del'=>0])->update(['is_del'=>1]);
                    return rjson(200,'修改成功',$bool);
                }else{
                      return rjson(0,'未修改');
                  }
              }
          }
          return rjson(0,'未修改');
      }
        $area_model = new AreaModel();
        $area_list = $area_model->index()['data'];
      return view('admin.basics.index',compact('area_list','result','id'));
    }

    public function list(){
        if($this->Request->method() == "POST"){
            $area_id = $this->Request->post('area_id');
            $where =['rent.is_del'=>0];
            if(!empty($area_id)){
                $where['rent.area_id']  = $area_id;
            }
            $result = $this->model->query()->from('jh_area_rent as rent')->where($where)
                ->leftJoin('jh_area as area','area.id','=','rent.area_id')
                ->select(['area.area_name','rent.*'])
                ->orderBy('rent.id','desc')->paginate();
            $result = getPaginateData($result);
            if(!empty($result['data'])){
                foreach ($result['data'] as $key=>$value){
                    $result['data'][$key]['key']  = $key+1;
                }
            }
            return rjson(0,'加载成功',$result);
        }
        $area_model = new AreaModel();
        $area_list = $area_model->index()['data'];
      return  view('admin.basics.list',compact('area_list'));
    }

    public function add(){
        if($this->Request->method() == "POST"){
            $data = $this->Request->post('data');
            $data =  Ajax_Arr($data);
            $data['create_time'] = date('Y-m-d H:i:s');
            $data['update_time'] = date('Y-m-d H:i:s');
            $check = $this->model->query()->where(['area_id'=>$data['area_id'],'is_del'=>0])->first();
                if(!empty($check)) return rjson(0,'该区域已存在设置');
                    $bool =   $this->model->query()->insertGetId($data);
                    if($bool){
                        return rjson(200,'添加成功');
                    }else{
                        return rjson(0,'添加失败');
                    }
            }
        $area_model = new AreaModel();
        $area_list = $area_model->index()['data'];
        return view('admin.basics.add',compact('area_list'));
    }

public function del()
{
    $id = $this->Request->post('id');
    $bool = $this->model->query()->where(['id' => $id])->update(['id_del' => 1]);
    if ($bool){
        return rjson(200,'删除成功');
    }else{
        return rjson(0,'删除失败');
    }
}


    public function rant_ext(){
        $models = new areaRantExtModel();
        if($this->Request->method() == "POST"){
            $data_all = $this->Request->post('data');
            if(!empty($data_all)){
                $number = 3;
                $surplus = 0;
                foreach($data_all as $key=>$value){
                    if($key%$number  == $surplus){ //0 1 2 3 4 5
                       if($value['name'] == 'id'){
                           $data = [
                               $data_all[$key+1]['name']=>$data_all[$key+1]['value'],
                               $data_all[$key+2]['name']=>$data_all[$key+2]['value'],
                           ];
//                           var_dump($data);die;
                           $models->query()->where([$data_all[$key]['name']=>$data_all[$key]['value']])->update($data);
                           $models->query()->where('id',$data_all[$key]['value'])->update(['is_del' => 1]);
                       }else{
                           if($key == 0){
                               $mul = 1;
                               $add = 0;
                           }else{
                               $mul = 0;
                               $add = 1;
                           }
                           $number = 2;
                           $surplus = 1;
                           $data = [
                             $data_all[$key-$mul]['name']=>$data_all[$key-$mul]['value'],
                             $data_all[$key+$add]['name']=>$data_all[$key+$add]['value'],
                               'create_time' => date('Y-m-d H:i:s')
                           ];
                           $models->query()->insert($data);
                       }
                    }
                    continue;
                }

                return rjson(200,'修改成功');
            }
            return rjson(200,'暂无修改');
        }

        $result =  $models->query()->where(['is_del'=>0])->orderBy('id','desc')->paginate();
        $result = getPaginateData($result)['data'];
        return  view('admin.basics.ext',compact('result'));
    }
}