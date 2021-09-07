<?php

namespace App\Http\Requests\admin;

use App\Http\Requests\admin\Base;

class Login extends Base
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
            'admin_pwd' => 'required|max:255',//必填
          
        ];
    }
    
    //错误信息
    public function messages()
    {
        return [
            'admin_name.required' => '账号不能为空',
            'admin_pwd.required'  => '密码不能为空',
        ];
    }

}
