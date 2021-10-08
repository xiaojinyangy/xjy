@extends('admin.public.header')
@section('body')
    <form class="layui-form layui-form-pane" id="area" style="margin:20px ">
        <div class="layui-form-item" style="width: 500px">
            <label class="layui-form-label">图文介绍</label>
            <div class="layui-input-block">
                <textarea id="demo" style="display: none;" name="content">{{isset($content) ? $content : "" }}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <a class="layui-btn" id="submit" >保存</a>
        </div>
    </form>
    <script>
            layui.use('layedit', function(){
                var layedit = layui.layedit;
                layedit.set({
                    uploadImage: {
                        url: '{{url("admin/webuploads/load")}}' //接口url
                        ,type: 'post' //默认post
                    }
                });
             var index =    layedit.build('demo'); //建立编辑器
                $("#submit").click(function () {
                    var content = layedit.getContent(index);
                    $.post("{{url('admin/system/text')}}",{content:content},function (data) {
                        if(data.code == 200){
                            layer.msg('保存成功');
                        }else{
                            layer.msg(data.msg);
                        }
                    })
                })
            });


    </script>
@endsection

