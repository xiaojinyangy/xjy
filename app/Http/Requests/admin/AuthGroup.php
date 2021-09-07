<?php

namespace App\Http\Requests\admin;

use App\Http\Requests\admin\Base;

class AuthGroup extends Base
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
            'group_name' => 'required|max:255',
            'group_status' => 'required',//必填
           
        ];
    }
    
    //错误信息
    public function messages()
    {
        return [
            'group_name.required' => '管理组名称不能为空',
            'group_name.max' => '管理组名称长度不能超过255',
            'group_status.required'  => '状态不能为空',
        ];
    }

}
