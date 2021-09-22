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
            <label class="layui-form-label">档口</label>
            <div class="layui-input-block">
                <input type="text" name="mouth_name" autocomplete="off" placeholder="请输入档口" class="layui-input" value="">
            </div>
        </div>

        <div class="layui-inline">
            <label class="layui-form-label">请选择范围</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input"  name="data" id="test15" placeholder=" -- ">
            </div>
        </div>
    </form>
    <div>
        <a id="search" class="layui-btn searchBtn layui-btn-sm">搜索</a>
        <a href="{{url('admin/hydropower/index')}}" class="layui-btn layui-btn-primary layui-btn-sm">清空</a>
    </div>
</div>
<table class="layui-table-body" id="user_table" lay-filter="user_table"></table>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-primary layui-btn-sm" lay-event="detail">查看</a>
    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
</script>
<script>
    layui.use(['table','laytpl','laydate'], function(){
        var table = layui.table;
        var laytpl = layui.laytpl
        var laydate = layui.laydate
        var form   = $("#form").serializeArray();
        laydate.render({
            elem: '#test15'
            ,type: 'month'
            ,range: '--'
            ,format: 'yyyy-M'
        });
        table.render({
            elem: '#user_table'
            ,url:'{{url('admin/hydropower/index')}}'
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,page:true
            ,method:"post"
            ,text:"暂无"
            ,limits:[15]
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
        ,where:{form:form}
    ,cols:[[
            // {type:'checkbox'},
            {field:'key',  title: '序号',sort: true,width:60,}
            ,{field:'id',title:'Id',hide:true}
            ,{field:'area_name',  title: '区域'}
            ,{field:'mouth_name', title: '档口'}
            ,{field:'date',title:'时间'}
            ,{field:'warte_title', title: '水表'}
            ,{field:'warte_last_month', title: '上月度数'}
            ,{field:'warte_this_month', title: '本月度数',}
            ,{field:'warte_this_number', title: '使用度数'} //minWidth：局部定义当前单元格的最小宽度，layui 2.2.1 新增
            ,{field:'electric_title', title: '电表'}
            ,{field:'electric_last_month', title: '上月度数'}
            ,{field:'electric_this_month', title: '本月度数',}
            ,{field:'electric_this_number', title: '消耗度数'}
        ]]
    });

        table.on('tool(user_table)',function (obj){
            var data = obj.data; //当前行的数据
            if(obj.event == 'detail'){
                {{--var url  =  window.location.href = "{{url('admin/shop/set')}}?id="+data.id;;--}}
                window.location.href = url;
            }else if(obj.event == 'del'){
                var form   = $("#form").serializeArray();
                $.post("{{url('admin/hydropower/del')}}",{id:data.id},function (data) {
                    if(data.code == 200){
                        layer.msg(data.msg)
                        // var phone = $("input[name=phone]")
                        table.reload('user_table', {
                            url: "{{url('admin/hydropower/index')}}",where: {form:form} //设定异步数据接口的额外参数
                        });
                    }
                })
            }else if(obj.event == 'edit'){

            }
        })

        $("#search").click(function () {
            var form   = $("#form").serializeArray();
            table.reload('user_table', {
                url: "{{url('admin/hydropower/index')}}",where: {form:form} //设定异步数据接口的额外参数
            });
        })
    });
</script>



@endsection

