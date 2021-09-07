<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class Base extends FormRequest
{
    //重写验证错误机制
    public function failedValidation(Validator $validator)
    {
        $error= $validator->errors()->first();
        throw new HttpResponseException(response()->json(['code'=>0,'msg'=>$error]));
    }
}
