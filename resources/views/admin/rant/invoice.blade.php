@extends('admin.public.header')
@section('body')
    <form class="layui-form layui-form-pane" id="area" style="margin:20px ">
        <div class="layui-form-item" style="width: 500px">
            <button type="button" class="layui-btn" id="test1">
                <i class="layui-icon">&#xe67c;</i>上传发票
            </button>
            <div class="layui-upload-list">
                <input type="hidden" value="" name="invoice" id="invoice">
                <img class="layui-upload-img" id="image" style="width:100px;height: 100px">
                <p id="demoText"></p>
                <div style="width: 100px;">
                    <div class="layui-progress layui-progress-big" lay-showpercent="yes" lay-filter="demo">
                        <div class="layui-progress-bar" lay-percent=""></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <input type="hidden" value="{{$id}}" id="id">
            <a class="layui-btn" id="submit" >上传</a>
        </div>
    </form>
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
                    $('#image').attr('src', res.filePaht); //图片链接（本地地址）
                    $('#invoice').attr('value', res.filePaht); //图片id
                    element.progress('demo', '100%'); //进度条复位
                    layer.msg('上传中', {icon: 16, time: 5});
                }
                ,error: function(){
                    //请求异常回调
                }
            });
        });

        $("#submit").click(function () {
            var id = $("#id").val();
            var invoice = $("#invoice").val()
            $.post("{{url('admin/shoprant/invoice')}}",{id:id,invoice:invoice},function (data) {
                if(data.code == 200){
                    layer.msg(data.msg)
                    window.close();
                    // var phone = $("input[name=phone]")
                }else{
                    layer.msg(data.msg)
                }
            })
        })
    </script>
@endsection

