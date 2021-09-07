@extends('admin.public.header')
@section('body')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>权限列表</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <style>
                                .list_head{width: 100%;overflow: hidden;}
                                .list_head span,.list_box span{display: block;float: left;color: #676a6c;text-align: center;}
                                .list_head span{font-weight: bold;height: 34px;line-height: 34px;}
                                .list_box{width: 100%;}
                                .list_box .box{border-top: 1px solid #e7eaec;}
                                .list_box ul{padding: 0;margin: 0;}
                                .list_box .sire.on,.list_box .sire:hover{background:#c6c6c6 ;}
                                .list_box .seed li{background: #eee;border-top: 1px solid #e7eaec;}
                                .list_box .sire,.list_box .seed li{overflow: hidden;}
                                .list_box span{height: 50px;line-height: 50px;}
                                .list_box .seed{display: none;}
                            </style>
                            <script>
                                $(function(){
                                    $(".list_box .sire").click(function(){
                                        $(".list_box .seed").stop().slideUp();  
                                        $(this).next().stop().slideToggle();      
                                        $(".list_box .sire").removeClass("on");
                                        $(this).addClass("on");
                                    });
                                });
                            </script>
                            <div class="list_head">
                                <span style="width: 4%;">序号</span>
                                <span style="width: 10%;">权限名称</span>
                                <span style="width: 20.5%;">路径（url）模块、控制器、方法</span>
                                <span style="width: 4.5%;">状态</span>
                                <span style="width: 42%;">规则表达式，为空表示存在就验证，不为空表示按照条件验证</span>
                                <span style="width: 19%;">操作</span>
                            </div>
                            <div class="list_box">
                                @foreach($rule['top'] as $vo)
                                <div class="box">
                                    <div class="sire">
                                        <span style="width: 4%;">{{$vo['rule_id']}}</span>
                                        <span style="width: 10%;">{{$vo['rule_name']}}</span>
                                        <span style="width: 20.5%;">{{$vo['rule_url']}}/</span>
                                        <span style="width: 4.5%;">
                                                @if($vo['rule_status']==1)
                                                   启用
                                                @else
                                                   禁用
                                                @endif
                                        </span>
                                        <span style="width: 42%;"></span>
                                        <span style="width: 19%;">
                                            @if( authchecks('admin/authrule/edit') )
                                            <a href="{{url('admin/authrule/edit/'.$vo['rule_id'])}}" class="btn btn-primary">编辑</a>
                                            @endif
                                            @if( authchecks('admin/authrule/del') )
                                            <a href="{{url('admin/authrule/del/'.$vo['rule_id'])}}" class="btn btn-danger js-ajax-delete">删除</a>
                                            @endif
                                            @if($vo['rule_status']==1)
                                                @if( authchecks('admin/authrule/ban') )
                                                <a href="{{url('admin/authrule/ban/'.$vo['rule_id'])}}" class="btn btn-danger btn-outline js-ajax-dialog-btn" data-msg="您确定要禁用吗？">禁用</a>
                                                @endif
                                            @else
                                                @if( authchecks('admin/authrule/cancelban') )
                                                <a href="{{url('admin/authrule/cancelban/'.$vo['rule_id'])}}" class="btn btn-primary btn-outline js-ajax-dialog-btn" data-msg="您确定要启用吗？">启用</a>
                                                @endif
                                            @endif                                      
                                        </span>
                                    </div>
                                    <div class="seed">
                                        <ul>
                                            @isset($vo['secondary'])
                                            @foreach($vo['secondary'] as $vos)
                                            <li>
                                                <span style="width: 4%;">{{$vos['rule_id']}}</span>
                                                <span style="width: 10%;">{{$vos['rule_name']}}</span>
                                                <span style="width: 20.5%;">{{$vos['rule_url']}}</span>
                                                <span style="width: 4.5%;">
                                                    @if($vos['rule_status']==1)
                                                       启用
                                                    @else
                                                       禁用
                                                    @endif
                                                </span>
                                                <span style="width: 42%;"></span>
                                                <span style="width: 19%;">
                                                    @if( authchecks('admin/authrule/edit') )
                                                    <a href="{{url('admin/authrule/edit/'.$vos['rule_id'])}}" class="btn btn-primary">编辑</a>
                                                    @endif
                                                    @if( authchecks('admin/authrule/del') )
                                                    <a href="{{url('admin/authrule/del/'.$vos['rule_id'])}}" class="btn btn-danger js-ajax-delete">删除</a>
                                                    @endif
                                                    @if($vos['rule_status']==1)
                                                        @if( authchecks('admin/authrule/ban') )
                                                        <a href="{{url('admin/authrule/ban/'.$vos['rule_id'])}}" class="btn btn-danger btn-outline js-ajax-dialog-btn" data-msg="您确定要禁用吗？">禁用</a>
                                                        @endif
                                                    @else
                                                        @if( authchecks('admin/authrule/cancelban') )
                                                        <a href="{{url('admin/authrule/cancelban/'.$vos['rule_id'])}}" class="btn btn-primary btn-outline js-ajax-dialog-btn" data-msg="您确定要启用吗？">启用</a>
                                                        @endif
                                                    @endif                                            
                                                </span>
                                            </li>
                                            @endforeach
                                            @endisset
                                        </ul>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="text-left pages">
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