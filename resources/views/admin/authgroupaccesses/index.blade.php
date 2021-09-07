@extends('admin.public.header')
@section('body')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>管理组成员列表</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{url('/admin/authgroupaccesses/index/'.$group_id)}}" method="post" role="form" class="form-inline" style="padding-bottom:30px;">
                            @csrf
                            管理名称: <input type="text" name="admin_name" value="{{$admin_name}}" style="width:200px;" class="form-control" />&nbsp;&nbsp;
                            <input type="submit" class="btn btn-success" value="搜索" style="margin-bottom: 0;"/>
                            <a class="btn btn-danger" href="{{url('/admin/authgroupaccesses/index/'.$group_id)}}">清空</a>
                            <a class="btn btn-danger" href="javascript:history.back(-1)">返回上一步</a>
                            @if( authchecks('admin/authgroupaccesses/add') )
                            <a href="{{url('/admin/authgroupaccesses/add/'.$group_id)}}" class="btn btn-primary">用户组成员添加</a>
                            @endif
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover ">
                                <thead>
                                <tr>
                                    <th style="text-align: center;">序号</th>
                                    <th style="text-align: center;">管理组名称</th>
                                    <th style="text-align: center;">管理名称</th>
                                    <th style="text-align: center;">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($authgroupaccesses as $vo)
                                        <tr>
                                            <td style="text-align: center;">{{$vo->accesses_id}}</td>
                                            <td style="text-align: center;">{{$vo->admin->admin_name}}</td>
                                            <td style="text-align: center;">{{$vo->group->group_name}}</td>
                                            <td style="text-align: center;">
                                                @if( authchecks('admin/authgroupaccesses/del') )
                                                <a href="{{url('/admin/authgroupaccesses/del/'.$vo->accesses_id)}}" class="btn btn-danger js-ajax-delete">删除</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-left pages">
                                {{ $authgroupaccesses->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="/admin/js/admin.js"></script>
@endsection