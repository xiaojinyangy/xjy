<?php

namespace App\Http\Requests\admin;

use App\Http\Requests\admin\Base;

class AuthGroupAccesses extends Base
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
            'admin_id' => 'required',
        ];
    }
    
    //错误信息
    public function messages()
    {
        return [
            'admin_id.required' => '管理员不能为空',
        ];
    }

}
