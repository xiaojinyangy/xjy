@extends('admin.public.header')
@section('body')
    <style type="text/css">
        .layui-table-cell {
            height: inherit;
            white-space: normal;
            vertical-align:top;
        }
    </style>
    <div style="margin:20px">
        <a href="{{url('admin/message/add')}}" class="layui-btn layui-btn-normal layui-btn-mini" lay-event="detail">添加</a>
    </div>
    <table class="layui-table-body" id="user_table" lay-filter="user_table" lay-data="{id: 'idTest'}"></table>
    <script type="text/html" id="barDemo">
{{--      //  <a  class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>--}}
        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
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
                url:"{{url('admin/message/index')}}",
                // cellMinWidth: 80,//全局定义常规单元格的最小宽度，layui 2.2.1 新增
                page:true
                ,limits:[15,20,30,50,100]
                , parseData:function(res){
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
                cols: [[
                    // {type:'checkbox'},
                    {field:'id', title:'ID', hide:true,align:"center"},
                    {field:'key', title:'序号', sort: true,align:"center"},
                    {field:'message', title: '通知',align:"center",width: '10%', minWidth: 100},
                    {field:'sort', title: '排序', sort: true,align:"center"},
                    //{field:'status',  title: '状态',type:"checkbox"},
                    {field:'button',title:'操作',width:200,toolbar:"#barDemo"}
                ]]
            });

            table.on('tool(user_table)',function (obj){
                var data = obj.data; //当前行的数据
                if(obj.event == 'edit'){
                    //window.location.href = "{{url('admin/image/set')}}" + '?id=' + data.id
                }
                if(obj.event == 'del'){
                    $.ajax({
                        url:"{{url('admin/message/del')}}",
                        dataType:"json",
                        method:'post',
                        data:{
                            id:data.id
                        },
                        success:function (data) {
                            if(data.code == 200){
                                layer.msg('删除成功');
                                table.reload('user_table', {
                                    url: "{{url('admin/message/index')}}",where: {} //设定异步数据接口的额外参数
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
