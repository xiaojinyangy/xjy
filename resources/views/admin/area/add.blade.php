@extends('admin.public.header')
@section('body')
    <form class="layui-form layui-form-pane" id="area" style="margin:20px ">
        <div class="layui-form-item" style="width: 500px">
            <label class="layui-form-label">区域名称</label>
            <div class="layui-input-block">
                <input type="text" name="area_name" autocomplete="off" placeholder="请输入区域名称" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-inline">
                <input type="number" name="sort" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" value=0>
            </div>
        </div>

        <div class="layui-form-item">
            <button class="layui-btn" id="submit" >添加</button>
            <a href="{{url('admin/area/index')}}" class="layui-btn" >返回</a>
        </div>
    </form>
    <script>
        $("#submit").click(function () {
            $.post("{{url('admin/area/add')}}",{data:$("#area").serializeArray()},function (data) {
                if(data.code == 200){
                    layer.msg('添加成功');
                }else{
                    layer.msg(data.msg);
                }
            })
        })

    </script>
@endsection
