@extends('admin.public.header')
@section('body')
    <form class="layui-form layui-form-pane" id="area" style="margin:20px ">
        <div class="layui-form-item" style="width: 500px">
            <label class="layui-form-label">图文介绍</label>
            <div class="layui-input-block">
                <textarea id="demo" style="display: none;" name="message">{{isset($content) ? $content : "" }}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-inline">
                <input type="number" name="sort" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" value=0>
            </div>
        </div>
        <div class="layui-form-item">
            <a class="layui-btn" id="submit" >发送</a>
            <a href="{{url('admin/message/index')}}" class="layui-btn" >返回</a>
        </div>
    </form>
    <script>
        layui.use('layedit', function(){
            var layedit = layui.layedit;
            var index =    layedit.build('demo'); //建立编辑器
            $("#submit").click(function () {
                var content = layedit.getContent(index);
                $.post("{{url('admin/message/add')}}",{message:content,sort:$("input[name=sort]").val()},function (data) {
                    if(data.code == 200){
                        layer.msg(data.msg,function () {
                            window.location.href = "{{url('admin/message/index')}}"
                        },2000);
                    }else{
                        layer.msg(data.msg);
                    }
                })
            })
        });


    </script>
@endsection

