@extends('admin.public.header')
@section('body')
    <form class="layui-form layui-form-pane" id="area" style="margin:20px ">
        <div class="layui-form-item" style="width: 500px">
            <button type="button" class="layui-btn" id="test1">
                <i class="layui-icon">&#xe67c;</i>上传图片
            </button>
            <div class="layui-upload-list">
                <input type="hidden" value="{{$data['image_id']}}" name="image_id" id="image_id">
                <img class="layui-upload-img" id="image" style="width:100px;height: 100px" src="{{$data['file_path']}}">
                <p id="demoText"></p>
                <div style="width: 100px;">
                    <div class="layui-progress layui-progress-big" lay-showpercent="yes" lay-filter="demo">
                        <div class="layui-progress-bar" lay-percent=""></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-inline">
                <input type="number" name="sort" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input" value={{$data['sort']}}>
            </div>
        </div>

        <div class="layui-form-item">
            <a class="layui-btn" id="submit" >添加</a>
            <a href="{{url('admin/image/index')}}" class="layui-btn" >返回</a>
        </div>
    </form>
    <input type="hidden" value="{{$home_image_id}}" id="id">
    <script>
        layui.use(['upload','element'], function(){
            var upload = layui.upload;
            var element = layui.element;
            //执行实例
            var uploadInst = upload.render({
                elem: '#test1' //绑定元素
                ,url: "{{url("admin/webuploads/index")}}" //上传接口
                ,done: function(res){
                    //上传完毕回调
                    $('#image').attr('src', res.src); //图片链接（本地地址）
                    $('#image_id').attr('value', res.id); //图片id
                    element.progress('demo', '100%'); //进度条复位
                    layer.msg('上传中', {icon: 16, time: 5});
                }
                ,error: function(){
                    //请求异常回调
                }
            });
        });

        $("#submit").click(function () {
            var id = $("#id").val()
            $.post("{{url('admin/image/set')}}",{data:$("#area").serializeArray(),id:id},function (data) {
                if(data.code == 200){
                    layer.msg(data.msg,function () {
                        window.location.href = "{{url('admin/image/set')}}?id="+id
                    },1000);

                }else{
                    layer.msg(data.msg);
                }
            })
        })
    </script>
@endsection

