@extends('admin.public.header')
@section('body')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>菜单列表</h5>
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
                                <span style="width: 4.5%;">序号</span>
                                <span style="width: 6.5%;">菜单名称</span>
                                <span style="width: 16%;">路径（url）模块、控制器、方法</span>
                                <span style="width: 4.5%;">排序</span>
                                <span style="width: 45%;"></span>
                                <span style="width: 19%;">操作</span>
                            </div>
                            <div class="list_box">
                                @foreach ($nav['top'] as $vo)
                                <div class="box">
                                    <div class="sire">
                                        <span style="width: 4.5%;">{{ $vo['nav_id'] }}</span>
                                        <span style="width: 6.5%;">{{ $vo['nav_name'] }}</span>
                                        <span style="width: 16%;">{{ $vo['nav_url'] }}/</span>
                                        <span style="width: 4.5%;">{{ $vo['nav_order'] }}</span>
                                        <span style="width: 45%;"></span>
                                        <span style="width: 19%;">
                                            @if( authchecks('admin/nav/edit') )
                                            <a href="{{url('admin/nav/edit/'.$vo['nav_id'])}}" class="btn btn-primary">编辑</a>
                                            @endif
                                            @if( authchecks('admin/nav/del') )
                                            <a href="{{url('admin/nav/del/'.$vo['nav_id'])}}" class="btn btn-danger js-ajax-delete">删除</a>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="seed">
                                        <ul>   
                                            @isset($vo['secondary'])
                                                @foreach ($vo['secondary'] as $vos)
                                                <li>
                                                    <span style="width: 4.5%;">{{ $vos['nav_id'] }}</span>
                                                    <span style="width: 6.5%;">{{ $vos['nav_name'] }}</span>
                                                    <span style="width: 16%;">{{ $vos['nav_url'] }}</span>
                                                    <span style="width: 4.5%;">{{ $vos['nav_order'] }}</span>
                                                    <span style="width: 45%;"></span>
                                                    <span style="width: 19%;">
                                                        @if( authchecks('admin/nav/edit') )
                                                        <a href="{{url('admin/nav/edit/'.$vos['nav_id'])}}" class="btn btn-primary">编辑</a>
                                                        @endif
                                                        @if( authchecks('admin/nav/del') )
                                                        <a href="{{url('admin/nav/del/'.$vos['nav_id'])}}" class="btn btn-danger js-ajax-delete">删除</a>
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