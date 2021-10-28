<?php


namespace App\Http\Requests\index;


class shop  extends Base
{
    /**
     * 权限 默认开启所有
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * 验证规则
     *
     * @return array
     */
    public function rules()
    {
       return [
            'area' => 'required', //区域
            'mouth'=> 'required', //档口
            'phone' =>'required',//电话
            'name' => 'required|max:55',//姓名
            'idcard' => 'required',//身份证
            'idcard_font' => '',
            'idcard_back' => 'required', //身份证照片
            'license' => 'required', //营业执照照片
            'is_control' =>'required', //是否为实际控制人 1 => 是 0=>否 默认 1
            'now_user_name' =>'', //实际控制人姓名
            'now_user_phone' => '',//实际控制人电话
        ];

    }

    //错误信息
    public function messages()
    {
        return [
            'area_id.required' => '请选择区域',
            'mouth_id.required' => '请选择档口',
            'phone.required' => '请填写电话号码',
            'name.required'  =>'请填写姓名',
            'id_no_image.required' =>'请上传' ,
            'license.required' => '请上传营业执照',
        ];
    }
}