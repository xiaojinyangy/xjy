<?php

namespace App\Http\Requests\admin;

use App\Http\Requests\admin\Base;

class AdminEdit extends Base
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
            'admin_name' => 'required|max:255',
            'admin_img' => 'nullable',//可以为null
            'admin_pwd' => 'nullable|between:6,30',
            'admin_level' => 'required',
            'admin_show' => 'required',
           
        ];
    }
    
    //错误信息
    public function messages()
    {
        return [
            'admin_name.required' => '管理员名称不能为空',
            'admin_name.max' => '管理员名称长度不能超过255',
            'admin_pwd.between'  => '密码长度大于6,小于30',
            'admin_level.required'  => '等级不能为空',
            'admin_show.required'  => '状态不能为空',
        ];
    }

}
