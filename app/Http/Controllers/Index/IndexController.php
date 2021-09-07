<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class IndexController extends Controller
{    
   	//首页
    public function index(Request $request)
    {    
        $data=[
         'index'=>'6666',
        ];

        return rjson(1,'ok',$data);
    }
}
