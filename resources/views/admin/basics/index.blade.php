@extends('admin.public.header')
@section('body')

    <form class="layui-form layui-form-pane" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">姓名</label>
            <div class="layui-input-inline">
                <input type="text" name="name"  class="layui-input" value="{{$result['name']}}">
            </div>
        </div>
        <div class="layui-form-item" pane="">
            <label class="layui-form-label">性别</label>
            <div class="layui-input-block">
                <input type="radio" name="sex" value="1" title="男" {{$result['sex'] == 1 ?  "checked" : ""}}>
                <input type="radio" name="sex" value="2" title="女" {{$result['sex'] == 2 ?  "checked" : ""}} >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">电话</label>
            <div class="layui-input-inline">
                <input type="text" name="phone"  disabled class="layui-input" value="{{$result['phone']}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">身份证号码</label>
            <div class="layui-input-inline">
                <input type="text" name="id_no"  class="layui-input" value="{{$result['id_no']}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">身份证照片</label>
            <div class="layui-input-inline">
                <img src="{{$result['id_no_image']}}" onclick="imagePreviewDialog(this.src)" width="100px" height="100px" class="layui-icon">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">营业执照照片</label>
            <div class="layui-input-inline">
                <img src="{{$result['license']}}" onclick="imagePreviewDialog(this.src)" width="100px" height="100px" class="layuis-icon">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">实际控制人</label>
            <div class="layui-input-inline">
                <input type="text" name="now_user_name"  class="layui-input" value="{{$result['now_user_name']}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">实际控制人电话</label>
            <div class="layui-input-inline">
                <input type="text" name="now_user_phone"   class="layui-input" value="{{$result['now_user_phone']}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">实际控制人身份证号码</label>
            <div class="layui-input-inline">
                <input type="text" name=now_user_phone"   class="layui-input" value="{{$result['now_user_phone']}}">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">公司名称</label>
            <div class="layui-input-inline">
                <input type="text" name="company_name"  class="layui-input" value="{{$result['company_name']}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">合同期限</label>
            <div class="layui-input-inline">
                <input type="text" name="contract_time"   class="layui-input" value="{{$result['contract_time']}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">经营类型</label>
            <div class="layui-input-inline">
                <input type="text" name="status"   class="layui-input" value="{{$result['company_type']}}">
            </div>
        </div>
        <div class="layui-form-item">
            <button class="layui-btn" id="submit" >编辑</button>
            <a href="{{url('admin/users/index')}}" class="layui-btn">返回</a>
        </div>
    </form>
    <script>
        layui.use(['form'],function () {
            var form  = layui.form;
            form.on('select(area)',function (data) {
                $.get("{{url('admin/shop_mouth/area_mouth')}}",{area_id:data.value},function(data){
                    $("#mouth").empty();
                    $("#mouth").append("<option value=''>全部</option>")
                    data.data.forEach(function (index) {
                        var str = "<option value="+ index.id + ">" + index.mouth_name + "<option>";
                        $("#mouth").append(str)
                    })
                    form.render();
                })
            })
        })
    </script>
@endsection
