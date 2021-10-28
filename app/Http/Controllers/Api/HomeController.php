<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\ImageModel;
use App\Models\MessageModel;
use App\Models\shopPayRant;
use App\Models\SystemModel;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     *身份选择
     */
    public function userIdentity(){
        $user_id = $this->request->get('user_id');
         $identity  = $this->request->post('identity');
         if(empty($identity)){
             return rjson(0,'请选择身份注册');
         }
         $userModel = new User();
        $bool =  $userModel->query()->where('user_id',$user_id)->update(['identity'=>$identity]);
        if($bool){
            return rjson(200,'选择成功');
        }
        return rjson(0,'选择失败');
    }
    /**
     * 首页
     * @return array
     */
    public function Home(){
        $user_id =  $this->request->get('id');
        $user_id = 1000;
        /**
         *首页轮播图
        **/
        $Image_model = new ImageModel();
        $home_image = $Image_model->index('api',['home.status'=>1]);
        $image = [];
        if(!empty($home_image)){
            foreach($home_image as $value){
                $image[] = config('appConfig.url_http').$value['file_path'];
            }
        }
        /**
         * 公告
         */
        $msgModel = new MessageModel();
        $message = $msgModel->query()->orderBy('create_time','desc')->select(['id','message'])->first();
        /**
         * 图文介绍
         */
        $SystemModel = new SystemModel();
        $system = $SystemModel->query()->where(['key'=>'about'])->orWhere(['key'=>'phone'])->select('key','value')->get()->toArray();
        $result = [];
        if(!empty($system)){
            foreach($system as $value){
                $result[$value['key']] = $value['value'];
            }
        }
        if(!empty($result['about'])){
            $result['about'] = fullTextImage($result['about']);
        }

            return rjson(200,'加载成功',['image'=>$image,'message'=>$message,'system'=>isset($result['about'])?$result['about']:"","phone" =>isset($result['phone']) ? $result['phone'] : "" ]);
    }



    public function message(){
        $state = $this->request->post('state');
        $model  = new MessageModel();
        if($state == 1){
            $message_id = $this->request->post('message_id');
            $where = [];
            if(!empty($message_id)){
                $where = ['id'=>$message_id];
            }
            $message = $model->query()->where($where)->orderBy('create_time','desc')->select(['id','message','title'])->first();
        }else if($state == 2){
            $message = $model->query()->orderBy('create_time','desc')->select(['id','message','create_time','title'])->paginate();
            $message = getPaginateData($message);
            foreach($message['data'] as &$value){
                $value['create_time']  = date('Y-m-d H:i:s',strtotime($value['create_time']));
            }
            $message = $message['data'];
        }
        return rjson(200,'加载成功',$message);
    }

}