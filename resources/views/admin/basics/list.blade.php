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
{{--            <div class="layui-form-item" style="width: 500px;display: inline-block" >--}}
{{--                <label class="layui-form-label">手机号</label>--}}
{{--                <div class="layui-input-block">--}}
{{--                    <input type="text" name="phone" autocomplete="off" placeholder="请输入手机号名称" class="layui-input" value="">--}}
{{--                </div>--}}
{{--            </div>--}}
        </form>
        <div>
            <a id="search" class="layui-btn searchBtn">搜索</a>
            <div style="float: right">
                <a id="add" class="layui-btn layui-btn-normal" >添加</a>
            </div>
        </div>

    </div>
    <table class="layui-table-body" id="user_table" lay-filter="user_table"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-primary layui-btn-sm" lay-event="detail">查看</a>
        {{--        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>--}}
        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
    </script>
    <script>
        layui.use(['table','laytpl'], function(){
            var table = layui.table;
            var laytpl = layui.laytpl
            table.render({
                elem: '#user_table'
                ,url:'{{url('admin/basics/list')}}'
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
                },request: {
                    limitName: 'perPage' //每页数据量的参数名，默认：limit
                }
                ,cols:[[
                    // {type:'checkbox'},
                    {field:'key',  title: '序号',sort: true,width:60,}
                    ,{field:'id',title:'Id',hide:true}
                    ,{field:'area_name',  title: '区域'}
                    ,{field:'rent_money', title: '特定区域租金'}
                    ,{field:'area_rent_money',title:'特定区域管理费'}
                    ,{field:'incidental_money', title: '综合费'}
                    ,{field:'water_money', title: '水费'}
                    ,{field:'electric_money', title: '电费',}
                    ,{field:'right', title: '操作', width:200,toolbar:"#barDemo"}
                ]]
            });

            table.on('tool(user_table)',function (obj){
                var data = obj.data; //当前行的数据
                if(obj.event == 'detail'){
                    window.location.href = "{{url("admin/basics/index")}}?id=" + data.id;
                }else if(obj.event == 'del'){
                    $.post("{{url('admin/basics/del')}}",{id:data.id},function (data) {
                        if(data.code == 200){
                            layer.msg(data.msg)
                            // var phone = $("input[name=phone]")
                            table.reload('user_table', {
                                url: "{{url('admin/basics/list')}}",where: {} //设定异步数据接口的额外参数
                            });
                        }
                    })
                }else if(obj.event == 'edit'){

                }
            })
        });
        $("#add").click(function () {
            window.location.href = "{{url('admin/basics/add')}}"
        })
    </script>



@endsection




