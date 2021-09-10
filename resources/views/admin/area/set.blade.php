@extends('admin.public.header')
@section('body')
    <form class="layui-form layui-form-pane" id="area" style="margin:20px ">
        <div class="layui-form-item" style="width: 500px">
            <label class="layui-form-label">区域名称</label>
            <div class="layui-input-block">
                <input type="text" name="area_name" autocomplete="off" placeholder="请输入区域名称" class="layui-input" value="{{isset($result['area_name']) ? $result['area_name'] : ""}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-inline">
                <input type="number" name="sort" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input"  value="{{$result['sort']}}">
            </div>
        </div>
            <input type="hidden" value="{{$id}}" name="id">
        <div class="layui-form-item">
            <button class="layui-btn" id="submit" >编辑</button>
            <a href="{{url('admin/area/index')}}" class="layui-btn" >返回</a>
        </div>
    </form>
    <script>
        $("#submit").click(function () {
            var id =  $("input[name=id]").val();
            var sort = $("input[name=sort]").val();
            var area_name = $("input[name=area_name]").val()
            $.post("{{url('admin/area/set')}}",{id:id,sort:sort,area_name:area_name},function (data) {
                if(data.code == 200){
                    layer.msg('编辑成功');
                }else{
                    layer.msg(data.msg);
                }
            })
        })

    </script>
@endsection
