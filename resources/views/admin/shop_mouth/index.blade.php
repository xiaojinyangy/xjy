@extends('admin.public.header')
@section('body')
    <div style="margin:20px">
        <form class="layui-form layui-form-pane" id="form" style="margin:20px;width:100%">
            <div class="layui-form-item" style="display: inline-block">
                <label class="layui-form-label">区域选择</label>
                <div class="layui-input-block">
                    <select name="area_id" lay-filter="aihao">
                        <option value="">全部</option>
                        @foreach($area_list['data']  as $v)
                            <option value="{{$v['id']}}">{{$v['area_name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item" style="width: 500px;display: inline-block" >
                <label class="layui-form-label">档口名称</label>
                <div class="layui-input-block">
                    <input type="text" name="mouth_name" autocomplete="off" placeholder="请输入档口名称" class="layui-input">
                </div>
            </div>
        </form>
        <div>
            <a id="search" class="layui-btn searchBtn layui-btn-sm">搜索</a>
            <a href="{{url('admin/shop_mouth/index')}}" class="layui-btn layui-btn-primary layui-btn-sm">清空</a>
            <a href="{{url('admin/shop_mouth/add')}}" class="layui-btn layui-btn-normal layui-btn-sm" lay-event="detail">添加</a>
        </div>
    </div>
<table class="layui-table-body" id="user_table" lay-filter="user_table"></table>
<script type="text/html" id="barDemo">
    <a  class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
</script>
<script>
    layui.use('table', function(){
        var table = layui.table;
        var tableReload = table.reload;
        var form = $("#form").serializeArray();
        table.reload = function(){
            var args = [];
            layui.each(arguments, function(index, item){
                args.push(item);
            });
            args[2] === undefined && (args[2] = true);
            return tableReload.apply(null, args);
        };
        table.render({
            elem: '#user_table',
            url:"{{url('admin/shop_mouth/index')}}",
            limits:[20,30,60,100],
           // cellMinWidth: 80,//全局定义常规单元格的最小宽度，layui 2.2.1 新增
            page:true,
            method:"post",
            parseData:function(res){
                return{
                    "code":res.code,
                    "msg":res.msg,
                    "data":res.data.data,
                    "page":res.data.currentPage,
                    "count":res.data.total
                }
            },request: {
                limitName: 'perPage' //每页数据量的参数名，默认：limit
            },
            where:{form:form},
            cols: [[
                // {type:'checkbox'},
                {field:'id', title:'ID', hide:true},
                {field:'key', title:'序号', sort: true, align:"center",},
                {field:'area_name', title: '区域名称', align:"center",},
                {field:'mouth_name', title: '档口名称', align:"center",},
                {field:'sort', title: '排序', sort: true, align:"center",},
                //{field:'status',  title: '状态',type:"checkbox", align:"center",},
                {field:'button',title:'操作',width:200,toolbar:"#barDemo", align:"center",}
            ]]
        });
        table.on('tool(user_table)',function (obj){
            var data = obj.data; //当前行的数据
            if(obj.event == 'edit'){
                window.location.href = "{{url('admin/shop_mouth/set')}}" + '?id=' + data.id
            }
             if(obj.event == 'del'){
                 $.ajax({
                     url:"{{url('admin/shop_mouth/del')}}",
                     dataType:"json",
                     method:'post',
                     data:{
                         id:data.id
                     },
                     success:function (data) {
                        if(data.code == 200){
                            layer.msg('删除成功');
                            var form = $("#form").serializeArray();
                            table.reload('user_table', {
                                url: "{{url('admin/shop_mouth/index')}}",where: {form:form} //设定异步数据接口的额外参数
                            });
                        }else{
                            layer.msg('删除失败');
                        }
                     },
                 })
            }
        })
        $("#search").click(function () {
           var  area_id =  $("select[name=area_id]").val()
            var  mouth_name =  $("input[name=mouth_name]").val()
            if((area_id == null || area_id == "") && (mouth_name == "" ||  mouth_name == null)){
                return;
            }

            var form = $("#form").serializeArray();
            table.reload('user_table', {
                url: "{{url('admin/shop_mouth/index')}}",where: {form:form} //设定异步数据接口的额外参数
            });
        })
    });
</script>



@endsection