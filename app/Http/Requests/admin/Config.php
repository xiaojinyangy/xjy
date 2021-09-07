<?php
namespace App\Http\Requests\admin;

use App\Http\Requests\admin\Base;

class Config extends Base
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
            'config_title' => 'required|max:50',
            'config_keywords' => 'required|max:50',//必填
            'config_desc' => 'required|max:100',
        ];
    }
    
    //错误信息
    public function messages()
    {
        return [
            'config_title.required' => '网址标题不能为空',
            'config_title.max' => '网址标题长度不能超过50',
            'config_keywords.required'  => '网址关键字不能为空',
            'config_keywords.max'  => '网址关键字长度不能超过50',
            'config_desc.required'  => '网址描述不能为空',
            'config_desc.max'  => '网址描述不能超过100',
        ];
    }

}
