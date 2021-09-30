@extends('admin.public.header')
@section('body')
    <style type="text/css">
        .layui-table-cell {
            height: inherit;
            white-space: normal;
            vertical-align:top;
        }
    </style>
    <div style="margin:20px" id="sreach">
        <form class="layui-form layui-form-pane" id="area" style="margin:20px;width:100%">
            <div class="layui-form-item" style="width: 500px;display: inline-block" >
                <label class="layui-form-label">手机号</label>
                <div class="layui-input-block">
                    <input type="text" name="phone" autocomplete="off" placeholder="请输入手机号名称" class="layui-input" value="">
                </div>
            </div>
        </form>
        <div>
            <a id="search" class="layui-btn searchBtn layui-btn-sm">搜索</a>
            <a href="{{url('admin/users/index')}}" class="layui-btn layui-btn-primary layui-btn-sm">清空</a>
        </div>
    </div>
    <table class="layui-table-body" id="user_table" lay-filter="user_table"></table>
        <script type="text/html" id="barDemo">
         <a class="layui-btn layui-btn-sm" lay-event="shop">店铺</a>
        <a class="layui-btn layui-btn-primary layui-btn-sm" lay-event="detail">查看</a>
        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
    </script>
<script>
    layui.use(['table','laytpl'], function(){

        var table = layui.table;
        var laytpl = layui.laytpl
        var phone = $("input[name=phone]").val()
        table.render({
            elem: '#user_table'
            ,url:'{{url('admin/users/index')}}'
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,page:true
             ,method:"post"
            ,text:"暂无"
            ,limits:[15,20,30,50,100]
            , parseData:function(res){
                    return{
                        "code":res.code,
                        "msg":res.msg,
                        "data":res.data.data,
                        "page":res.data.currentPage,
                        "count":res.data.total
                    }
                },
                request: {
                    limitName: 'perPage' //每页数据量的参数名，默认：limit
                },where:{phone:phone},
                cols: [[
                // {type:'checkbox'},
                {field:'key',  title: '序号',sort: true,width:60,align:"center"}
                ,{field:'user_id',  title: 'ID', hide:true,align:"center"}
                ,{field:'headpic', title: '头像', width: '10%', minWidth: 100,type:"image"} //minWidth：局部定义当前单元格的最小宽度，layui 2.2.1 新增
                ,{field:'nick_name', title: '用户名',align:"center"}
                ,{field:'phone', title: '电话',align:"center"}
                ,{field:'sex', title: '性别',align:"center"}
                ,{field:'identity', title: '身份',align:"center"}
                ,{field:'region', title: '城市',align:"center"}
                ,{field:'regist_time', title: '注册时间',sort: true,align:"center"}
                ,{field:'right', title: '操作', width:200,toolbar:"#barDemo"}
            ]]
        });

        table.on('tool(user_table)',function (obj){
            var data = obj.data; //当前行的数据
            if(obj.event == 'detail'){
                var url  = "{{url('admin/users/info')}}?id=" + data.user_id;
                window.location.href = url;
            }else if(obj.event == 'del'){
               $.post("{{url('admin/users/del')}}",{id:data.user_id},function (data) {
                      if(data.code == 200){
                          layer.msg(data.msg)
                          var phone = $("input[name=phone]").val()
                          table.reload('user_table', {
                              url: "{{url('admin/users/index')}}",where: {phone:phone} //设定异步数据接口的额外参数
                          });
                      }
               })
            }else if(obj.event == 'shop'){
                  window.location.href =  "{{url('admin/users/user_shop')}}?id=" + data.user_id;
            }
        })

        $("#search").click(function () {
            var phone = $("input[name=phone]").val();
            table.reload('user_table', {
                url: "{{url('admin/users/index')}}",where: {phone:phone} //设定异步数据接口的额外参数
            });
        })
    });
</script>



@endsection