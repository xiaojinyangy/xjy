<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

use App\Http\Requests\index\shop;
use App\Models\JobModel;
use App\Models\ShopJob;
use App\Models\User;
use Illuminate\Http\Request;
use PHPUnit\Util\Json;

class shopController extends Controller
{
    protected  $request;
    protected   $model;
    public function __construct(Request $request)
    {
        $this->request =  $request;
        $this->model = new \App\Models\Shop();
    }

    /**
     * 我的商铺
     * @return array
     */
    public function  userShop(){
        $user_id = $this->request->get('user_id');
    
        $user_model = new User();
        $userInfo =  $user_model->query()->find($user_id);
        if(empty($userInfo)){
            return  rjson(0,'用户数据不存在');
        }
        if($userInfo->identity == 2 ){
           //店长
            $result =   $this->model->query()->from('jh_user_shop as a')
                ->leftJoin('jh_shop_mouth as c','c.id','a.mouth')
                ->leftJoin('jh_area as p','p.id','a.area')
                ->where(['a.user_id'=>$user_id])
                ->select(['a.id','p.area_name','c.mouth_name','a.status'])
                ->paginate();
            $result = getPaginateData($result);
             foreach($result['data'] as $v){
                $returnData[] = [
                    'shop_id' => $v['id'],
                    "area_name"=>$v['area_name'],
                    "mouth_name"=>$v['mouth_name'],
                    "status"=>$v['status'],
                ];
            }
            return rjson(200,'加载成功',$result['data']);
        }else if ($userInfo->identity == 1){
            //员工
            $shopJobModel =new ShopJob();
          $result =   $shopJobModel->query()->where(['user_id'=>$user_id])->with(['shop'=>function($query){
                $query->with(['mouths:id,mouth_name','areas:id,area_name'])->select(['id','user_id','id','area','mouth','name']);
            }])->paginate();
            $result = getPaginateData($result);
            $returnData =[];

            foreach($result['data'] as $v){
                $returnData[] = [
                    'shop_id' =>$v['shop_id'],
                    'id' => $v['id'],
                    "area_name"=>isset($v['shop']['areas']['area_name']) ? $v['shop']['areas']['area_name'] :"",
                    "mouth_name"=>isset($v['shop']['mouths']['mouth_name']) ? $v['shop']['mouths']['mouth_name']:"",
                    "status"=>$v['status'],
                    'shop_user_name' =>$v['shop']['name'],
                ];
            }
            return rjson(0,'加载成功',$returnData);


        }else{
            return rjson(0,'网络异常');
        }

    }
    /**
     * 添加商铺
     * @return array
     */
    public function  addShop(shop $shopRequest){
        $user_id = $shopRequest->get('id');
        $user_id = 1000;
        $data =  $shopRequest->validated();
      //  $preg5 = '/^(1[1-5]{1}[0-2]{1}|2[1-3]{1}[0-2]{1}|3[0-2]{1}[0-1]{1})[0-9]{1}[0-8]{1}[0-9]{1}(19[0-9]{2}|200[0-9]{1}|201[0-5]{1})((01|03|05|07|08|10|12){0,1}(0[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})|(04|06|09|11)(0[1-9]{1}|[1-2]{1}[0-9]{1}|30)|02(0[1-9]{1}|[1-2]{1}[0-9]{1}))[0-9]{3}[0-9xX]{1}$/';
        if($data['control'] == 0){
          $now_user_name = $this->request->post('c_name');
          $now_user_phone  = $this->request->post('c_phone');
          $c_idcard = $this->request->post('c_idcard');
          if(empty($now_user_name)) return rjson(0,'请填写实际控制人姓名');
          if(empty($now_user_phone)) return rjson(0,'请填写实际控制人电话');
            if(empty($c_idcard)) return rjson(0,'请填写实际控制人身份证');
            $data['c_name'] = $now_user_name;
            $data['c_phone'] = $now_user_phone;
            $data['c_idcard'] = $now_user_phone;
        }
        $data['user_id'] = $user_id;
        $judge = $this->model->add($data);
        if($judge > 0 ){
            return rjson(200,'添加成功');
        }
            return rjson(0,'添加失败');

    }
    /**
     * 修改商铺(回显)
     * @return array
     */
    public function setShopView(){
        $user_id = $this->request->get('id');
        $user_id = 1000;
        $shop_id = $this->request->post('shop_id');
       $shopInfo =  $this->model->query()->where(['id'=>$shop_id,'user_id'=>$user_id])->first();
        $shopInfo['area_mouth'] = $shopInfo['area'] . "," . $shopInfo['mouth'];
        unset($shopInfo['area'],$shopInfo['mouth']);
       if(empty($shopInfo)) return rjson(0,'网络异常,请稍后再试');
       return  rjson(200,'加载成功',$shopInfo);

    }
        public  function  delShop(){
            $user_id = $this->request->get('id');
            $user_id = 1000;
            $shop_id = $this->request->post('shop_id');
            $bool = $this->model->query()->where('id',$shop_id)->update(['is_del'=>1]);
            if($bool){
                return rjson(200,'删除成功');
            }
            return rjson(0,'删除成功');
        }
    /**
     * 修改商铺信息
     * @param shop $shopRequest
     * @return array
     */
    public function setShopData(shop $shopRequest){
        $user_id = $this->request->get('id');
        $shop_id = $this->request->post('shop_id');
        $data = $shopRequest->validated();
        if($data['control'] == 0){
            $now_user_name = $this->request->post('c_name');
            $now_user_phone  = $this->request->post('c_phone');
            $c_idcard = $this->request->post('c_idcard');
            if(empty($now_user_name)) return rjson(0,'请填写实际控制人姓名');
            if(empty($now_user_phone)) return rjson(0,'请填写实际控制人电话');
            if(empty($c_idcard)) return rjson(0,'请填写实际控制人身份证');
            $data['c_name'] = $now_user_name;
            $data['c_phone'] = $now_user_phone;
            $data['c_idcard'] = $now_user_phone;
        }
        $check = $this->model->query()->where(['id'=>$shop_id])->update($data);
        if($check){
            return rjson(200,'修改成功');
        }
        return rjson(0,'修改失败');
    }


    /**
     * 商铺的员工
     * @return array
     */
    public function shopJob()
    {
        $user_id = $this->request->get('user_id');
        $user_id = 1000;
        $shopData  = $this->model->getMyShop($user_id);
        $shopIdArr =[];
        if(!empty($shopData)){
            foreach($shopData as $v){
                $shopIdArr[] = $v['id'];
            }
        }
        $shopJobModel = new ShopJob();

        $result = $shopJobModel->query()->with(['job:id,name,status,phone','user:user_id,headpic'])
            ->select(['id','shop_id','job_id','status','user_id'])
            ->whereIn('shop_id',$shopIdArr)
            ->paginate();

        $result = getPaginateData($result);
        $returnData = [];

        if (!empty($result['data'])) {
            foreach ($result['data'] as $value) {
                if (isset($value['job'])) {
                    $value['job']['status'] = $value['status'];
                    $value['job']['headpic'] = isset($value['user']['headpic']) ? $value['user']['headpic']: "";
                        if ($value['status'] == 0) {
                            $returnData['no'][] = $value['job'];
                        } else {
                            $returnData['yes'][] = $value['job'];
                        }
                }
            }
            $returnData['no_number'] = count($returnData['no']);
            $returnData['my_job'] = count($returnData['yes']);
            return rjson(200, '加载成功', $returnData);
        }
    }

    /**
     *同意员工申请
     * @return array
     */
public function agree(){
    $user_id = $this->request->get('id');
    $job_id = $this->request->get('job_id');
    $model = new ShopJob();
    $check = $model->edit(['job_id'=>$job_id],['status'=>1]);
    if($check){
        return rjson(200,'操作成功');
    }
    return rjson(200,'操作失败');

}
    /**
     * 拒绝员工申请
     * @return array
     */
    public function refuse(){
        $user_id = $this->request->get('id');
        $job_id = $this->request->get('job_id');
        $model = new ShopJob();
        $check = $model->edit(['id'=>$job_id],['status'=>2]);
        if($check){
            return rjson(200,'操作成功');
        }
        return rjson(0,'操作失败');
    }

    /**
     * 移除员工
     * @return array
     */
    public function remove(){
        $user_id = $this->request->get('id');
        $job_id = $this->request->get('job_id');
        $model = new ShopJob();
        $check = $model->del(['id'=>$job_id]);
        if($check){
            return rjson(200,'操作成功');
        }
        return rjson(0,'操作失败');
    }



}