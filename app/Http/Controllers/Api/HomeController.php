<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\ImageModel;
use App\Models\MessageModel;
use App\Models\SystemModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * 首页
     * @return array
     */
    public function Home(){
        /**
         *首页轮播图
        **/
        $Image_model = new ImageModel();
        $home_image = $Image_model->index('api',['home.status'=>1]);
        $image = [];
        if(!empty($home_image)){
            foreach($home_image as $value){
                $image[] = config('url_http').$value['file_path'];
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
        return rjson(200,'加载成功',['image'=>$image,'message'=>$message,'system'=>$result]);
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
            $message = $model->query()->where($where)->orderBy('create_time','desc')->select(['id','message'])->first();
        }else if($state == 2){
            $message = $model->query()->orderBy('create_time','desc')->select(['id','message'])->get();
        }
        return rjson(200,'加载成功',$message);
    }
}