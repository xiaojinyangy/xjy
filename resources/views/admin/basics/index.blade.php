@extends('admin.public.header')
@section('body')

    <form class="layui-form layui-form-pane" action="" id="from" style="margin: 20px 20px">
        <div class="layui-form-item" style="display: inline-block">
            <label class="layui-form-label">区域选择</label>
            <div class="layui-input-block">
                <select name="area_id" lay-filter="area" id="arae">
                    <option value="">全部</option>
                    @foreach($area_list  as $v)
                        <option value="{{$v['id']}}"  {{$v['id'] == $result['area_id'] ? 'selected': ''}}>{{$v['area_name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">特定区域租金单价</label>
            <div class="layui-input-inline">
                <input type="number" name="rent_money"  class="layui-input" value="{{isset($result['rent_money'])? $result['rent_money'] : 0}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">特定区域管理费</label>
            <div class="layui-input-inline">
                <input type="number" name="area_rent_money"  class="layui-input" value="{{isset($result['area_rent_money']) ? $result['area_rent_money'] : 0}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">综合费</label>
            <div class="layui-input-inline">
                <input type="number" name="incidental_money"  class="layui-input" value="{{isset($result['incidental_money']) ? $result['incidental_money'] : 0}}">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">水费</label>
            <div class="layui-input-inline">
                <input type="number" name="water_money"  class="layui-input" value="{{isset($result['water_money']) ? $result['water_money'] :0}}">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">电费</label>
            <div class="layui-input-inline">
                <input type="number" name="electric_money"  class="layui-input" value="{{isset($result['electric_money']) ?  $result['electric_money'] : 0}}">
            </div>
        </div>
        <div class="layui-form-item">
            <a class="layui-btn" id="submit" >编辑</a>
            <a href="{{url('admin/basics/list')}}" class="layui-btn">返回</a>
        </div>
    </form>
    <input type="hidden" name="id" value="{{$id}}">
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
        $("#submit").click(function () {
            var id = $("input[name=id]").val();
            $.post("{{url('admin/basics/index')}}",{data:$("#from").serializeArray(),id:id},function (res) {
                layer.msg(res.msg,function () {
                    window.location.href = "{{url('admin/basics/index')}}?id=" + res.data;
                },500);
            })
        })
    </script>
@endsection
