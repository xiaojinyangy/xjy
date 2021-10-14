<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

use App\Http\Requests\index\shop;
use App\Models\ShopJob;
use App\Models\User;
use Illuminate\Http\Request;

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
        $user_id = $this->request->get('id');
        $user_id =1000;
        $user_model = new User();
        $userInfo =  $user_model->query()->find($user_id);
        $result =   $this->model->query()->from('jh_user_shop as a')
            ->leftJoin('jh_shop_mouth as c','c.id','a.mouth_id')
            ->leftJoin('jh_area as p','p.id','a.area_id')
            ->where(['a.user_id'=>$user_id])
            ->select(['p.area_name','c.mouth_name','a.status'])
            ->paginate();
        $result = getPaginateData($result);
        $returnData = [
            "user_name" => $userInfo->nick_name,
            "phone" =>  $userInfo->phone,
            "headpic" => $userInfo->headpic,
            "shop_number" => $result['total'],
            "list" => $result['data'],
          //   $data['user_id'] = $user_id
        ];
        return rjson(200,'测试',$returnData);
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
        if($data['is_control'] == 0){
          $now_user_name = $this->request->post('now_user_name');
          $now_user_phone  = $this->request->post('now_user_phone');
          if(empty($now_user_name)) return rjson(0,'请填写实际控制人姓名');
          if(empty($now_user_phone)) return rjson(0,'请填写实际控制人电话');
            $data['now_user_name'] = $now_user_name;
            $data['now_user_phone'] = $now_user_phone;
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
        $shopInfo['area_mouth'] = $shopInfo['area_id'] . "," . $shopInfo['mouth_id'];
        unset($shopInfo['area_id'],$shopInfo['mouth_id']);
       if(empty($shopInfo)) return rjson(0,'网络异常,请稍后再试');
       return  rjson(200,'加载成功',$shopInfo);

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
        if($data['is_control'] == 0){
            $now_user_name = $this->request->post('now_user_name');
            $now_user_phone  = $this->request->post('now_user_phone');
            if(empty($now_user_name)) return rjson(0,'请填写实际控制人姓名');
            if(empty($now_user_phone)) return rjson(0,'请填写实际控制人电话');
            $data['now_user_name'] = $now_user_name;
            $data['now_user_phone'] = $now_user_phone;
        }
        $check = $this->model->query()->where(['id'=>$shop_id])->update($data);
        if($check){
            return rjson(200,'修改成功');
        }
        return rjson(0,'修改失败');
    }


    /**
     * 商铺的会员
     * @return array
     */
    public function shopJob()
    {
        $user_id = $this->request->get('id');
        $user_id = 1000;
        $result = $this->model->query()
            ->with(['area:id,area_name', 'mouth:id,mouth_name', 'job' => function ($query) {
                $query->with('job:id,name,phone,status')->select(['job_id', 'shop_id']);
            }])
            ->select(['id', 'area_id', 'mouth_id', 'status'])
            ->where(['user_id' => $user_id])
            ->paginate();
        $result = getPaginateData($result);
        $returnData = [];
        if (!empty($result['data'])) {
            foreach ($result['data'] as $value) {
                $returnData['area'] = $value['area']['area_name'];
                $returnData['mouth'] = $value['mouth']['mouth_name'];
                if (isset($value['job']))
                    foreach ($value['job'] as $v) {
                        $returnData['job'][] = $v['job'];
                    }
            }
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
    $check = $model->edit(['id'=>$job_id],['status'=>1]);
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