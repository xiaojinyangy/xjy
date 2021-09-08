@extends('admin.public.header')
@section('body')
    <table class="layui-table-body" id="user_table" lay-filter="user_table"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-primary layui-btn-mini" lay-event="detail">查看</a>
        <a class="layui-btn layui-btn-mini" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-mini" lay-event="del">删除</a>
    </script>
<script>
    layui.use('table', function(){

        var table = layui.table;
        table.render({
            elem: '#user_table'
            ,url:'/demo/table/user/'
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,page:true
            ,cols: [[
                // {type:'checkbox'},
                {field:'id', width:80, title: 'ID', sort: true}
                ,{field:'username', width:80, title: '用户名'}
                ,{field:'sex', width:80, title: '性别', sort: true}
                ,{field:'city', width:80, title: '城市'}
                ,{field:'sign', title: '签名', width: '30%', minWidth: 100} //minWidth：局部定义当前单元格的最小宽度，layui 2.2.1 新增
                ,{field:'experience', title: '积分', sort: true}
                ,{field:'score', title: '评分', sort: true}
                ,{field:'classify', title: '职业'}
                ,{field:'wealth', width:137, title: '财富', sort: true}
                ,{field:'wealth', width:137, title: '财富', sort: true}
                ,{field:'wealth', width:137, title: '财富', sort: true}
                ,{field:'wealth', width:137, title: '财富', sort: true}
                ,{field:'right', title: '操作', width:200,toolbar:"#barDemo"}
            ]]
        });

        table.on('tool(user_table)',function (obj){
            var data = obj.data; //当前行的数据
            if(obj.event == 'detail'){
                var url  = "";
            }else if(obj.event == 'del'){
                var url  = "";
            }else if(obj.event == 'edit'){
                var url  = "";
            }
           $.ajax({
               url:url,
               dataType:"json",
               data:{

               },
               success:function () {

               }
               error:function () {

               }
           })
        })
    });
</script>



@endsection