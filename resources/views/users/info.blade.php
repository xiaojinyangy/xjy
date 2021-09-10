@extends('admin.public.header')
@section('body')

    <form class="layui-form layui-form-pane" action="">
{{--        <div class="layui-form-item">--}}
{{--            <label class="layui-form-label">长输入框</label>--}}
{{--            <div class="layui-input-block">--}}
{{--                <input type="text" name="title" autocomplete="off" placeholder="请输入标题" class="layui-input">--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="layui-form-item">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-inline">
                <input type="text" name="nick_name"  disabled class="layui-input" value="{{$result['nick_name']}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">头像</label>
            <div class="layui-input-inline">
                <img src="{{$result['headpic']}}" onclick="imagePreviewDialog(this.src)" width="100px" height="100px" class="layui-icon">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">电话</label>
            <div class="layui-input-inline">
                <input type="text" name="phone"  disabled class="layui-input" value="{{$result['phone']}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">地址</label>
            <div class="layui-input-inline">
                <input type="text" disname="region"  disabled class="layui-input" value="{{$result['region']}}">
            </div>
        </div>




{{--        <div class="layui-form-item" pane="">--}}
{{--            <label class="layui-form-label">开关-开</label>--}}
{{--            <div class="layui-input-block">--}}
{{--                <input type="checkbox" checked="" name="open" lay-skin="switch" lay-filter="switchTest" title="开关">--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="layui-form-item" pane="">
            <label class="layui-form-label">性别</label>
            <div class="layui-input-block">
                @if($result['sex'] == 1)
                <input type="radio" name="sex" value="1" title="男" {{$result['sex'] == 1 ?  "checked" : ""}}>
                @else
                <input type="radio" name="sex" value="2" title="女" {{$result['sex'] == 2 ?  "checked" : ""}} >
                @endif
            </div>
        </div>

        <div class="layui-form-item" pane="">
            <label class="layui-form-label">单选框</label>
            <div class="layui-input-block">
                @if($result['identity'] == 1)
                    <input type="radio" name="identity" value="1" title="员工" {{$result['identity'] == 1 ?  "checked" : ""}}>
                @elseif($result['identity'] == 2 )
                    <input type="radio" name="identity" value="2" title="店长" {{$result['identity'] == 2 ?  "checked" : ""}}>
                 @else
                    <input type="radio" name="identity" value="0" title="普通用户" {{$result['identity'] == 0 ?  "checked" : ""}}>
                @endif
            </div>
        </div>

        <div class="layui-form-item">
            <a href="{{url('admin/users/index')}}" class="layui-btn">返回</a>
        </div>
    </form>


@endsection