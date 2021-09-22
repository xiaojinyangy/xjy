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

            <div class="layui-inline">
                <label class="layui-form-label">状态</label>
                <div class="layui-input-inline">
                    <select name="status">
                        <option value="">全部</option>
                        <option value="0">未缴费</option>
                        <option value="1">已缴费</option>
                        <option value="2">超时</option>
                    </select>
                </div>
            </div>
        </form>
        <div>
            <a id="search" class="layui-btn searchBtn layui-btn-sm">搜索</a>
            <a  href="{{url('admin/shoprant/index')}}" class="layui-btn layui-btn-primary layui-btn-sm">清空</a>
        </div>
    </div>
    <table class="layui-table-body" id="user_table" lay-filter="user_table"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-primary layui-btn-sm" lay-event="detail">确认支付</a>
        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="uppay">上传发票</a>
    </script>

    <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">

        </div>
    </script>
    <script>
        layui.use(['table','laytpl'], function(){
            var table = layui.table;
            var laytpl = layui.laytpl
            var form = $("form").serializeArray();
            // laytpl.config({
            //     open:'<%',
            //     close:'%>'
            // })
            table.render({
                elem: '#user_table'
                ,url:'{{url('admin/shoprant/index')}}'
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
                ,toolbar: '#toolbarDemo' //开启头部工具栏，并为其绑定左侧模板
                ,totalRow: true
                ,defaultToolbar:['exports']
                ,cols:[[
                    // {type:'checkbox'},
                    {field:'key',  title: '序号',sort: true,width:60,totalRowText: '合计'}
                    ,{field:'id',title:'Id',hide:true}
                    ,{field:'status',title:'状态',align:"center"}
                    ,{field:'pay_type',title:'支付类型',align:"center"}
                    ,{field:'area_name',  title: '区域',align:"center"}
                    ,{field:'mouth_name', title: '档口',align:"center"}
                    ,{field:'rent_money', title: '租金',align:"center",totalRow: true}
                    ,{field:'area_rent_money', title: '管理费',align:"center",totalRow: true}
                    ,{field:'incidental_money', title: '综合费',align:"center",totalRow: true}
                    ,{field:'warte_last_month', title: '上月水表度数',align:"center"}
                    ,{field:'warte_this_month', title: '本月水表度数',align:"center"}
                    ,{field:'water_this_money', title: '水费',align:"center",totalRow: true}
                    ,{field:'electric_last_month', title: '上月电表度数',align:"center"}
                    ,{field:'electric_this_month', title: '本月电表度数',align:"center"}
                    ,{field:'electric_this_money', title: '电费',align:"center",totalRow: true}
                    ,{field:'sum_money', title: '总金额',align:"center",totalRow: true}
                    ,{field:'button',title:'操作',width:200, align:"center",totalRow: true}
                ]]
            });

            table.on('tool(user_table)',function (obj){
                var data = obj.data; //当前行的数据
                if(obj.event == 'detail'){
                    $.post("{{url('admin/shoprant/surepay')}}",{id:data.id},function (data) {
                        if(data.code == 200){
                            layer.msg(data.msg)
                            // var phone = $("input[name=phone]")
                            var form = $("form").serializeArray();
                            table.reload('user_table', {
                                url: "{{url('admin/shoprant/index')}}",where: {form:form} //设定异步数据接口的额外参数
                            });
                        }
                    })
                }else if(obj.event == 'uppay'){
                    layer.open({
                        type: 2,
                        area: ['700px', '450px'],
                        fixed: false, //不固定
                        maxmin: true,
                        content: "{{url('admin/shoprant/invoice')}}?id=" + data.id,
                        end:function () {
                            var form = $("form").serializeArray();
                            table.reload('user_table', {
                                url: "{{url('admin/shoprant/index')}}",where: {form:form} //设定异步数据接口的额外参数
                            });
                        }
                    });

                }else if(obj.event == 'edit'){

                }
            })
            $("#search").click(function () {
                var form = $("#form").serializeArray();
                table.reload('user_table', {
                    url: "{{url('admin/shoprant/index')}}",where: {form:form} //设定异步数据接口的额外参数
                });
            })


        });
    </script>



@endsection

