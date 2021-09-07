@extends('admin.public.header')
@section('body')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>用户组列表</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{url('/admin/authgroup/index')}}" method="post" role="form" class="form-inline" style="padding-bottom:30px;">
                            @csrf
                            用户组名称: <input type="text" name="group_name" value="{{$group_name}}" style="width:200px;" class="form-control" />&nbsp;&nbsp;
                            <input type="submit" class="btn btn-success" value="搜索" style="margin-bottom: 0;"/>
                            <a class="btn btn-danger" href="{{url('/admin/authgroup/index')}}">清空</a>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover ">
                                <thead>
                                <tr>
                                    <th style="text-align: center;">序号</th>
                                    <th style="text-align: center;">用户组名称</th>
                                    <th style="text-align: center;">状态</th>
                                    <th style="text-align: center;">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                        @foreach($authgroup as $vo)
                                        <tr>
                                            <td style="text-align: center;">{{$vo->group_id}}</td>
                                            <td style="text-align: center;">{{$vo->group_name}}</td>
                                            <td style="text-align: center;">
                                                @if($vo->group_status==1)
                                                   启用
                                                @else
                                                   禁用
                                                @endif
                                            </td>
                                            <td style="text-align: center;">
                                                @if( authchecks('admin/authgroupaccesses/index') )
                                                <a href="{{url('/admin/authgroupaccesses/index/'.$vo->group_id)}}" class="btn btn-primary">用户组成员管理</a>
                                                @endif
                                                @if( authchecks('admin/authgroup/allocate') )
                                                <a href="{{url('/admin/authgroup/allocate/'.$vo->group_id)}}" class="btn btn-primary">权限分配</a>
                                                @endif
                                                @if( authchecks('admin/authgroup/edit') )
                                                <a href="{{url('/admin/authgroup/edit/'.$vo->group_id)}}" class="btn btn-primary">编辑</a>
                                                @endif
                                                @if( authchecks('admin/authgroup/del') )
                                                <a href="{{url('/admin/authgroup/del/'.$vo->group_id)}}" class="btn btn-danger js-ajax-delete">删除</a>
                                                @endif
                                                @if($vo->group_status==1)
                                                    @if( authchecks('admin/authgroup/ban') )
                                                    <a href="{{url('/admin/authgroup/ban/'.$vo->group_id)}}" class="btn btn-danger btn-outline js-ajax-dialog-btn" data-msg="您确定要禁用吗？">禁用</a>
                                                    @endif
                                                @else
                                                    @if( authchecks('admin/authgroup/cancelban') )
                                                    <a href="{{url('/admin/authgroup/cancelban/'.$vo->group_id)}}" class="btn btn-primary btn-outline js-ajax-dialog-btn" data-msg="您确定要启用吗？">启用</a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                            <div class="text-left pages">
                                {{ $authgroup->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="/admin/js/admin.js"></script>
@endsection