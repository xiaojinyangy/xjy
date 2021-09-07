@extends('admin.public.header')
@section('body')
	<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                	<div class="ibox-title">
                        <h5>配置管理</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{url('/admin/config/postedit')}}" method="post" class="form-horizontal js-ajax-form m-t">
                            @csrf
                            <div class="form-group">
                                <label class="col-sm-3 control-label">网站标题：</label>
                                <div class="col-sm-8">
                                    <input name="config_title" type="text" class="form-control" value="{{$config->config_title}}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">网站关键字：</label>
                                <div class="col-sm-8">
                                    <input name="config_keywords" type="text" class="form-control" value="{{$config->config_keywords}}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">网站描述：</label>
                                <div class="col-sm-8">
                                    <textarea name="config_desc" class="form-control" >{{$config->config_desc}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-3">
                                    @if( authchecks('admin/config/postedit') )
                                    <button class="btn btn-primary js-ajax-submit" type="submit">保存</button>
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