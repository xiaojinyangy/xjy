<?php

namespace App\Http\Requests\admin;

use App\Http\Requests\admin\Base;

class AuthRule extends Base
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
            'rule_name' => 'required|max:255',
            'rule_url' => 'required|max:255',//必填
            'parent_id' => 'integer',//数值
            'rule_status' => 'required',//必填
            'rule_condition' => 'nullable',//验证字段可以为 null
        ];
    }
    
    //错误信息
    public function messages()
    {
        return [
            'rule_name.required' => '权限名称不能为空',
            'rule_name.max' => '权限名称长度不能超过255',
            'rule_url.required'  => 'url不能为空',
            'rule_url.max'  => 'url长度不能超过255',
            'parent_id.integer'  => '上级是数值',
            'rule_status.required'  => '状态不能为空',
        ];
    }

}
