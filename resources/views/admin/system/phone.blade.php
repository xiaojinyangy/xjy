@extends('admin.public.header')
@section('body')
    <form class="layui-form layui-form-pane" id="area" style="margin:20px ">
        <div class="layui-form-item" style="width: 500px">
            <label class="layui-form-label">联系号码</label>
            <div class="layui-input-block">
                <input type="text" name="phone" autocomplete="off" placeholder="请输入电话号码" class="layui-input" value="{{isset($phone) ? $phone : ""}}">
            </div>
        </div>
        <div class="layui-form-item">
            <a class="layui-btn" id="submit" >保存</a>
        </div>
    </form>
    <script>
        $("#submit").click(function () {
            $.post("{{url('admin/system/phone')}}",{phone:$("input[name=phone]").val()},function (data) {
                if(data.code == 200){
                    layer.msg('保存成功');
                }else{
                    layer.msg(data.msg);
                }
            })
        })

    </script>
@endsection

