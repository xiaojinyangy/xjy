<?php
namespace App\Http\Requests\index;

use App\Http\Requests\index\Base;

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
            'user_phone' => 'required',
        ];
    }
    
    //错误信息
    public function messages()
    {
        return [
            'user_phone.required' => '手机号不能为空',
        ];
    }

}
