@extends('admin.public.header')
@section('body')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>管理员列表</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{url('/admin/admin/index')}}" method="post" role="form" class="form-inline" style="padding-bottom:30px;">
                                @csrf
                                管理员: <input type="text" name="admin_name" value="{{$admin_name}}" placeholder="请输入管理员" style="width:200px;" class="form-control" />&nbsp;&nbsp;
                                状态:
                                <select class="form-control" name="admin_show">
                                    <option value="">全部</option>
                                    <option {{$admin_show==1?'selected':''}} value="1" >启用</option>
                                    <option {{$admin_show==2?'selected':''}} value="2" >禁用</option>
                                </select>&nbsp;&nbsp;
                                 登录时间：
                                <input placeholder="开始日期" name="start_time" value="{{$start_time}}" class="form-control layer-date" id="start">--
                                <input placeholder="结束日期" name="end_time" value="{{$end_time}}" class="form-control layer-date" id="end">
                            <input type="submit" class="btn btn-success" value="搜索" style="margin-bottom: 0;"/>
                            <a class="btn btn-danger" href="{{url('/admin/admin/index')}}">清空</a>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover ">
                                <thead>
                                <tr>
                                    <th style="text-align: center;">序号</th>
                                    <th style="text-align: center;">管理员</th>
                                    <th style="text-align: center;">管理頭像</th>
                                    <th style="text-align: center;">登录ip</th>
                                    <th style="text-align: center;">登录时间</th>
                                    <th style="text-align: center;">上次登录ip</th>
                                    <th style="text-align: center;">上次登录时间</th>
                                    <th style="text-align: center;">等级</th>
                                    <th style="text-align: center;">状态</th>
                                    <th style="text-align: center;">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $vo)
                                        <tr>
                                            <td style="text-align: center;">{{$vo->admin_id}}</td>
                                            <td style="text-align: center;">{{$vo->admin_name}}</td>
                                            <td style="text-align: center;">
                                                <img src="{{$vo->admin_img!=''?$vo->admin_img :'/admin/img/profile_small.jpg'}}" width="50" height="50"  onclick="imagePreviewDialog(this.src);" style="cursor: pointer;"/>
                                            </td>
                                            <td style="text-align: center;">{{$vo->admin_ip}}</td>
                                            <td style="text-align: center;">
                                                @if($vo->admin_time == null)
                                                  该管理员还没登陆过
                                                @else
                                                  {{$vo->admin_time}}
                                                @endif
                                            </td>
                                            <td style="text-align: center;">{{$vo->admin_last_ip}}</td>
                                            <td style="text-align: center;">
                                                @if($vo->admin_last_time == null)
                                                  该管理员还没登陆过
                                                @else
                                                  {{$vo->admin_last_time}}
                                                @endif
                                            </td>
                                            <td style="text-align: center;">
                                                @if($vo->admin_level == 1)
                                                  超级管理员
                                                @else
                                                  管理员
                                                @endif
                                            </td>
                                            <td style="text-align: center;">
                                                @if($vo->admin_show == 1)
                                                  启用
                                                @else
                                                  禁用
                                                @endif
                                            </td>
                                            @if($vo->admin_level == 1)
                                            <td style="text-align: center;">
                                                <font color="#cccccc">编辑</font>
                                                <font color="#cccccc">删除</font>
                                                <font color="#cccccc">禁用</font>
                                            </td>
                                            @else
                                            <td style="text-align: center;">
                                                @if( authchecks('admin/admin/edit') )
                                                <a href="{{url('/admin/admin/edit/'.$vo->admin_id)}}" class="btn btn-primary">编辑</a>
                                                @endif
                                                @if( authchecks('admin/admin/del') )
                                                <a href="{{url('/admin/admin/del/'.$vo->admin_id)}}" class="btn btn-danger js-ajax-delete">删除</a>
                                                @endif
                                                @if($vo->admin_show == 1)
                                                    @if( authchecks('admin/admin/ban') )
                                                    <a href="{{url('/admin/admin/ban/'.$vo->admin_id)}}" class="btn btn-danger btn-outline js-ajax-dialog-btn" data-msg="您确定要禁用吗？">禁用</a>
                                                    @endif
                                                @else
                                                    @if( authchecks('admin/admin/cancelban') )
                                                    <a href="{{url('/admin/admin/cancelban/'.$vo->admin_id)}}" class="btn btn-primary btn-outline js-ajax-dialog-btn" data-msg="您确定要启用吗？">启用</a>
                                                    @endif
                                                @endif
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-left pages">
                                {{ $list->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="/admin/js/admin.js"></script>
<script>
    //日期范围限制
    var start = {
        elem: '#start',
        format: 'YYYY-MM-DD hh:mm:ss',
        min: '1970-01-01 23:59:59', //设定最小日期为当前日期
        max: '2100-01-01 23:59:59', //最大日期
        istime: true,
        istoday: false,
        choose: function (datas) {
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };
    var end = {
        elem: '#end',
        format: 'YYYY-MM-DD hh:mm:ss',
        min: '1970-01-01 23:59:59',
        max: '2100-01-01 23:59:59',
        istime: true,
        istoday: false,
        choose: function (datas) {
            start.max = datas; //结束日选好后，重置开始日的最大日期
        }
    };
    laydate(start);
    laydate(end);
</script>
@endsection