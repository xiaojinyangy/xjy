@extends('admin.public.header')
@section('body')
    <div style="margin:20px">
        <style type="text/css">
            .layui-table-cell {
                height: inherit;
                white-space: normal;
                vertical-align:top;
            }
        </style>
        <form class="layui-form layui-form-pane" id="area" style="margin:20px;width:100%">
            <div class="layui-form-item" style="width: 500px;display: inline-block" >
                <label class="layui-form-label">员工编号</label>
                <div class="layui-input-block">
                    <input type="text" name="jon_number" autocomplete="off" placeholder="请输入员工编号" class="layui-input">
                </div>
            </div>
        </form>
        <div>
            <a id="search" class="layui-btn searchBtn layui-btn-sm">搜索</a>
            <a href="{{url('admin/job/index')}}" class="layui-btn layui-btn-primary layui-btn-sm">清空</a>
            <a href="{{url('admin/job/add')}}" class="layui-btn layui-btn-normal layui-btn-sm" lay-event="detail">添加</a>
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
            table.reload = function(){
                var args = [];
                layui.each(arguments, function(index, item){
                    args.push(item);
                });
                args[2] === undefined && (args[2] = true);
                return tableReload.apply(null, args);
            };
            var  jon_number =  $("input[name=jon_number]").val()
            table.render({
                elem: '#user_table',
                method:'post',
                url:"{{url('admin/job/index')}}",
                limits:[20,30,60,100],
                // cellMinWidth: 80,//全局定义常规单元格的最小宽度，layui 2.2.1 新增
                page:true,
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
                },where:{jon_number:jon_number},
                cols: [[
                    // {type:'checkbox'},
                    {field:'id', title:'ID', hide:true},
                    {field:'key', title:'序号', sort: true, align:"center",},
                    {field:'job_number', title: '工号', align:"center"},
                    {field:'button',title:'操作',width:200,toolbar:"#barDemo", align:"center",}
                ]]
            });
            table.on('tool(user_table)',function (obj){
                var data = obj.data; //当前行的数据
                if(obj.event == 'edit'){
                    window.location.href = "{{url('admin/job/set')}}" + '?id=' + data.id
                }
                if(obj.event == 'del'){
                    $.ajax({
                        url:"{{url('admin/job/del')}}",
                        dataType:"json",
                        method:'post',
                        data:{
                            id:data.id
                        },
                        success:function (data) {
                            if(data.code == 200){
                                layer.msg('删除成功');
                                table.reload('user_table', {
                                    url: "{{url('admin/job/index')}}",where: {} //设定异步数据接口的额外参数
                                });
                            }else{
                                layer.msg('删除失败');
                            }
                        },
                    })
                }
            })
            $("#search").click(function () {
                var  jon_number =  $("input[name=jon_number]").val()
                if((jon_number == "" ||  jon_number == null)){
                    return;
                }
                table.reload('user_table', {
                    url: "{{url('admin/job/index')}}",where: {jon_number:jon_number} //设定异步数据接口的额外参数
                });
            })
        });
    </script>



@endsection
