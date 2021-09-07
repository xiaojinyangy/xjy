@extends('admin.public.header')
@section('body')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>添加管理组成员</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{url('/admin/authgroupaccesses/add/'.$group_id)}}" method="post" role="form" class="form-inline" style="padding-bottom:30px;">
                            @csrf
                            管理名称: <input type="text" name="admin_name" value="{{$admin_name}}"  style="width:200px;" class="form-control" />&nbsp;&nbsp;
                            <input type="submit" class="btn btn-success" value="搜索" style="margin-bottom: 0;"/>
                            <a class="btn btn-danger" href="{{url('/admin/authgroupaccesses/add/'.$group_id)}}">清空</a>
                            <a class="btn btn-danger" href="javascript:history.back(-1)">返回上一步</a>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover " id="f3">
                                <form action="{{url('/admin/authgroupaccesses/postadd/'.$group_id)}}" method="post" role="form" class="form-inline js-ajax-form" style="padding-bottom:30px;">
                                    <thead>
                                    <tr>
                                        <th>选项框</th>
                                        <th style="text-align: center;">序号</th>
                                        <th style="text-align: center;">管理员</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                            @foreach($admins as $vo)
                                            <tr>
                                                <td><input type="checkbox" name="admin_id[]" data-id="{{$vo['admin_id']}}" value="{{$vo['admin_id']}}" style="cursor: pointer;"></td>
                                                <td style="text-align: center;">{{$vo['admin_id']}}</td>
                                                <td style="text-align: center;">{{$vo['admin_name']}}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="7" style="text-align: left;">
                                                    <button onclick="return selectall(true);" class="btn btn-primary">全选</button>
                                                    <button onclick="return selectall(false);" class="btn btn-primary">反选</button>
                                                    @if( authchecks('admin/authgroupaccesses/postadd') )
                                                    <button type="submit" class="btn btn-success js-ajax-submit">将管理加入管理组</button>
                                                    @endif
                                                </td>
                                            </tr>
                                    </tbody>
                                </form>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="/admin/js/admin.js"></script>
<script type="text/javascript">
    // 选择
    function selectall(sign){
        var testForm = document.getElementById('f3');
        var ipts = testForm.getElementsByTagName('input');
        if(sign){
            for(var i = 0; i < ipts.length; i++){
                ipts[i].checked = sign;
            }
        }else{
            for(var i = 0; i < ipts.length; i++){
                ipts[i].checked = !ipts[i].checked;
            }
        }
        return false;
    }
</script>
@endsection