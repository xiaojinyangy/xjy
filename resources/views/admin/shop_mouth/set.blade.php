@extends('admin.public.header')
@section('body')
    <form class="layui-form layui-form-pane" id="area" style="margin:20px;width:400px">
        <div class="layui-form-item">
            <label class="layui-form-label">区域选择</label>
            <div class="layui-input-block">
                <select name="area_id" lay-filter="aihao">
                    <option value="">全部</option>
                    @foreach($area_list['data']  as $v)
                        <option value="{{$v['id']}}" {{$result['area_id'] == $v['id'] ? 'selected' : ''}}>{{$v['area_name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item" style="width: 500px">
            <label class="layui-form-label">档口名称</label>
            <div class="layui-input-block">
                <input type="text" name="mouth_name" autocomplete="off" placeholder="请输入档口名称" class="layui-input" value="{{isset($result['mouth_name']) ? $result['mouth_name'] : ""}}">
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
            <a href="{{url('admin/shop_mouth/index')}}" class="layui-btn" >返回</a>
        </div>
    </form>
    <script>
        $("#submit").click(function () {
            var id =  $("input[name=id]").val();
            var sort = $("input[name=sort]").val();
            var mouth_name = $("input[name=mouth_name]").val()
            $.post("{{url('admin/shop_mouth/set')}}",{id:id,sort:sort,mouth_name:mouth_name},function (data) {
                if(data.code == 200){
                    layer.msg('编辑成功');
                }else{
                        layer.msg(data.msg);
                    }

            })
        })

    </script>
@endsection
