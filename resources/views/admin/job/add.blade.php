@extends('admin.public.header')
@section('body')
    <form class="layui-form layui-form-pane" id="area" style="margin:20px;width: 400px">
        <div class="layui-form-item" style="width: 500px">
            <label class="layui-form-label">员工编号</label>
            <div class="layui-input-block">
                <input type="text" name="job_number" autocomplete="off" placeholder="请输入员工编号" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-inline">
                <input type="password" name="password" lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input" >
            </div>
        </div>

        <div class="layui-form-item">
            <button class="layui-btn" id="submit" >添加</button>
            <a href="{{url('admin/job/index')}}" class="layui-btn" >返回</a>
        </div>
    </form>
    <script>
        $("#submit").click(function () {
            var job_number = $("input[name=job_number]").val()
            if(job_number == "" || job_number==null){
                layer.alert('请填写员工编号');
            }
            var pass = $("input[name=password]").val()
            if(pass == "" || pass==null){
                layer.alert('请填写员工密码');
            }
            $.post("{{url('admin/job/add')}}",{job_number:job_number,password:pass},function (data) {
                if(data.code == 200){
                    layer.msg('添加成功');
                }else{
                    layer.msg(data.msg);
                }
            })
        })

    </script>
@endsection
