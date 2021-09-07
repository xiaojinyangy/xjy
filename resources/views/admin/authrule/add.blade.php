@extends('admin.public.header')
@section('body')
    <body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>添加权限</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{url('/admin/authrule/postadd')}}" method="post" class="form-horizontal js-ajax-form m-t">
                            @csrf
                            <div class="form-group">
                                <label class="col-sm-3 control-label">权限名称：</label>
                                <div class="col-md-6 col-sm-10">
                                    <input name="rule_name" type="text" class="form-control" value="" placeholder="请输入权限名称" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">路径（url）模块、控制器、方法：</label>
                                <div class="col-md-6 col-sm-10">
                                    <input name="rule_url" type="text" class="form-control" value="" placeholder="index/user/index" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">状态：</label>
                                <div class="col-md-6 col-sm-10">
                                    <label class="radio-inline i-checks">
                                        <input type="radio" name="rule_status" checked value="1" > 启用
                                    </label>
                                    <label class="radio-inline i-checks">
                                        <input type="radio" name="rule_status" value="0" > 禁用
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">规则表达式，为空表示存在就验证，不为空表示按照条件验证：</label>
                                <div class="col-md-6 col-sm-10">
                                    <input name="rule_condition" type="text" class="form-control" value="" placeholder="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">上级id：</label>
                                <div class="col-md-6 col-sm-10">
                                    <select name="parent_id" class="form-control">
                                        <option value="0">请选择上级</option>
                                        @foreach($authrule as $vo)
                                        <option value="{{$vo->rule_id}}">{{$vo->rule_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-3">
                                    @if( authchecks('admin/authrule/postadd') )
                                    <button class="btn btn-primary js-ajax-submit" type="submit">添加</button>
                                    @endif
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