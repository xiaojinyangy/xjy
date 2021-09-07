@extends('admin.public.header')
@section('body')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                	<div class="ibox-title">
                        <h5>添加菜单</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{url('admin/nav/postadd')}}" method="post" class="form-horizontal js-ajax-form m-t">
                            @csrf
                            <div class="form-group">
                                <label class="col-sm-3 control-label">菜单名称：</label>
                                <div class="col-md-6 col-sm-10">
                                    <input name="nav_name" type="text" class="form-control" value="" placeholder="请输入菜单名称" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">路径（url）模块、控制器、方法：</label>
                                <div class="col-md-6 col-sm-10">
                                   <input name="nav_url" type="text" class="form-control" value="" placeholder="index/admin/index" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">排序：</label>
                                <div class="col-md-6 col-sm-10">
                                   <input name="nav_order" type="text" class="form-control" value="255" placeholder="请输入排序" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" style="padding-top:0px !important">上级菜单：</label>
                                <div class="col-md-6 col-sm-10">
                                    <select name="parent_id" class="form-control" >
                                        <option value="0">请选择上级菜单</option>
                                        @foreach($nav as $vo)
                                        <option value="{{$vo->nav_id}}">{{$vo->nav_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-3">
                                    @if( authchecks('admin/nav/postadd') )
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