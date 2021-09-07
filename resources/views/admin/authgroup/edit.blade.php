@extends('admin.public.header')
@section('body')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                	<div class="ibox-title">
                        <h5>编辑管理组</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{url('/admin/authgroup/postedit/'.$authgroup->group_id)}}" method="post" class="form-horizontal js-ajax-form m-t">
                            @csrf
                        	<div class="form-group">
                                <label class="col-sm-3 control-label">管理组名称：</label>
                                <div class="col-md-6 col-sm-10">
                                    <input name="group_name" type="text" class="form-control" value="{{$authgroup->group_name}}" placeholder="请输入管理组名称" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" style="padding-top:0px !important">状态：</label>
                                <div class="col-md-6 col-sm-10">
                                   <label class="radio-inline i-checks">
                                        <input type="radio" name="group_status" {{$authgroup->group_status==1?"checked":""}} value="1" > 启用
                                   </label>
                                   <label class="radio-inline i-checks">
                                        <input type="radio" name="group_status" {{$authgroup->group_status==0?"checked":""}} value="0" > 禁用
                                   </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-3">
                                    @if( authchecks('admin/authgroup/postedit') )
                                    <button class="btn btn-primary js-ajax-submit" type="submit">保存</button>
                                    @endif
                                    <a class="btn btn-default" href="{{url('/admin/authgroup/index')}}">返回</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="/admin/js/admin.js"></script>
@endsection