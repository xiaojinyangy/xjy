@extends('admin.public.header')
@section('body')
    <div style="margin:20px">
        <a href="{{url('admin/area/add')}}" class="layui-btn layui-btn-normal layui-btn-mini" lay-event="detail">添加</a>
    </div>
<table class="layui-table-body" id="user_table" lay-filter="user_table" lay-data="{id: 'idTest'}"></table>
<script type="text/html" id="barDemo">
    <a  class="layui-btn layui-btn-mini" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-mini" lay-event="del">删除</a>
</script>
<script>
    layui.use('table', function(){
        var table = layui.table;
        var tableReload = table.reload;
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
            method:'post',
            url:"{{url('admin/area/index')}}",
           // cellMinWidth: 80,//全局定义常规单元格的最小宽度，layui 2.2.1 新增
            page:true,
            cols: [[
                // {type:'checkbox'},
                {field:'id', title:'ID', hide:true},
                {field:'key', title:'序号', sort: true},
                {field:'area_name', title: '区域名'},
                {field:'sort', title: '排序', sort: true},
                //{field:'status',  title: '状态',type:"checkbox"},
                {field:'button',title:'操作',width:200,toolbar:"#barDemo"}
            ]]
        });

        table.on('tool(user_table)',function (obj){
            var data = obj.data; //当前行的数据
            if(obj.event == 'edit'){
                window.location.href = "{{url('admin/area/set')}}" + '?id=' + data.id
            }
             if(obj.event == 'del'){
                 $.ajax({
                     url:"{{url('admin/area/del')}}",
                     dataType:"json",
                     method:'post',
                     data:{
                         id:data.id
                     },
                     success:function (data) {
                        if(data.code == 200){
                            layer.msg('删除成功');
                            table.reload('user_table', {
                                url: "{{url('admin/area/index')}}",where: {} //设定异步数据接口的额外参数
                            });
                        }else{
                            layer.msg('删除失败');
                        }
                     },
                     error:function () {

                     }
                 })
            }

        })
    });
</script>



@endsection