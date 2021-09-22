<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\JobModel;
use App\Models\ShopJob;
use Illuminate\Http\Request;

class JobController extends Controller
{
    protected $Model;
    protected $Request;
    public function __construct(Request $request)
    {
        $this->Request = $request;
        $this->Model = new JobModel(); //员工
    }

    /**\
     *显示
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function  index(){
        if($this->Request->method() == "POST"){
            $job_number = $this->Request->post('jon_number');
            $where = [];
            if(!empty($job_number)){
                $where = ["job_number" => $job_number];
            }
            $result = $this->Model->index($where);
            if(!empty($result)){
                foreach($result['data'] as $key=>$value){
                    $result['data'][$key]['key'] = $key+1;
                }
            }

            return rjson(0,'加载成功',$result);
        }
        return view('admin/job/index');
    }

    /**
     * 添加
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        if($this->Request->method() == "POST"){
            $job_number = $this->Request->post('job_number');
           $check_job =  $this->Model->index(['job_number'=>$job_number],2);
           if(!empty($check_job)){
               return rjson(0,'工号重复,请更换');
           }
            $password = $this->Request->post('password');
           $data = [
               "job_number" => $job_number,
               "password" => md5(md5($password).config('appConfig.passKey')),
               'create_time' => date('Y-m-d H:i:s')
           ];
            $bool = $this->Model->add($data);
            if($bool){
                return rjson(200,'添加成功');
            }
            return  rjson(0,'添加失败');
        }
        return view('admin/job/add');
    }

    /**
     * 修改
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function set(){
        $id = $this->Request->input('id');
        if($this->Request->method() == "POST"){
            $job_number = $this->Request->post('job_number');
            $check_job =  $this->Model->index(['job_number'=>$job_number],2);
            $old_data = $this->Model->index(['id'=>$id],2);
            if(!empty($check_job)){
                return rjson(0,'工号重复,请更换');
            }
            $password = $this->Request->post('password');
            if($password != $old_data['password'] ){
                $password = md5(md5($password).config('appConfig.passKey'));
            }
            $data = [
                "job_number" => $job_number,
                "password" =>$password,
            ];
            $bool = $this->Model->query()->where(['id'=>$id])->update($data);
            if($bool){
                return rjson(200,'修改成功');
            }
            return  rjson(0,'修改失败');
        }
        $check_job =  $this->Model->index(['id'=>$id],2);
        return view('admin/job/set',compact('check_job','id'));
    }

    /**
     * 删除
     * @return array
     */
    public function del(){
        $id = $this->Request->post('id');
        $bool = $this->Model->query()->where(['id'=>$id])->delete();
        if($bool){
            $shop_job_model = new ShopJob();
            $shop_job_model->query()->where(['job_id'=>$id])->delete();
           return rjson(0,'删除成功');
        }
        return rjson(0,'删除失败');
    }
}