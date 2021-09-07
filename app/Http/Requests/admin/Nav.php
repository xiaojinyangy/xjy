<?php

namespace App\Http\Requests\admin;

use App\Http\Requests\admin\Base;

class Nav extends Base
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
            'nav_name' => 'required|max:255',
            'nav_url' => 'required|max:255',//必填
            'parent_id' => 'integer',//数值
            'nav_order' => 'required|integer|max:255',//数值
        ];
    }
    
    //错误信息
    public function messages()
    {
        return [
             'nav_name.required' => '菜单名称不能为空',
            'nav_name.max' => '菜单名称长度不能超过255',
            'nav_url.required'  => 'url不能为空',
            'nav_url.max'  => 'url长度不能超过255',
            'parent_id.integer'  => '上级是数值',
            'nav_order.required'  => '排序不能为空',
            'nav_order.integer'  => '排序是数值',
            'nav_order.max'  => '排序数值不能超过255',
        ];
    }

}
