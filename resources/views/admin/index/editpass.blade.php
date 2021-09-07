@extends('admin.public.header')
@section('body')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="{{url('/admin/index/posteditpass')}}" method="post" class="form-horizontal js-ajax-form margin-top-20">
                            @csrf
                            <div class="form-group">
                                <label class="col-sm-3 control-label">新密码：</label>
                                <div class="col-sm-8">
                                    <input id="newpassword" type="password" class="form-control" name="admin_pwd" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">确认密码：</label>
                                <div class="col-sm-8">
                                    <input id="confpassword" type="password" class="form-control" name="admin_pwds" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-3">
                                    @if( authchecks('admin/index/posteditpass') )
                                    <button type="submit" class="btn btn-primary js-ajax-submit">提交</button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="/admin/js/admin.js"></script>
@endsection