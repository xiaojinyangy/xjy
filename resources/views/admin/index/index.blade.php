@section('title', $config->config_title)
@section('keywords', $config->config_keywords)
@section('description', $config->config_desc)
@extends('admin.public.header')
@section('body')
    <body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
        <div id="wrapper">
            <!--左侧导航开始-->
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="nav-close"><i class="fa fa-times-circle"></i>
                </div>
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="nav-header">
                            <div class="dropdown profile-element">
                                <span><img alt="image" class="img-circle" style="width: 50px;height: 50px;" src="{{$admin->admin_img == null?'/admin/img/profile_small.jpg':$admin->admin_img}}"/></span>
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="clear">
                                        <span class="block m-t-xs"><strong class="font-bold">欢迎您，{{$admin->admin_name}}</strong></span>
                                            @if($admin->admin_level == 1)
                                            <span class="text-muted text-xs block">超级管理员<b class="caret"></b></span>
                                            @else
                                            <span class="text-muted text-xs block">管理员<b class="caret"></b></span>
                                            @endif
                                    </span>
                                </a>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                    <li><a href="/" title="" target="_blank">网站首页</a></li>   
                                    @if( authchecks('admin/index/editpass') )
                                    <li><a class="J_menuItem" href="{{url('admin/index/editpass')}}">修改密码</a></li>
                                    @endif
                                    <li class="divider"></li>
                                    <li><a href="{{url('admin/login/logout')}}">安全退出</a></li>
                                </ul>
                            </div>
                            <div class="logo-element"><img alt="image" class="img-circle" src="/admin/img/profile_small.jpg" style="width: 40%;"/></div>
                        </li>
                        @isset($menu_arr['top'])
                        @foreach($menu_arr['top'] as $vo)
                        <li>
                            <a href="#">
                                <i class="fa fa fa-user-secret"></i>
                                <span class="nav-label">{{$vo['nav_name']}}</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level">
                                @isset($vo['secondary'])
                                @foreach($vo['secondary'] as $vos)
                                <li>
                                    <a class="J_menuItem" href="{{url($vos['nav_url'])}}">{{$vos['nav_name']}}</a>
                                </li>
                                @endforeach
                                @endisset
                            </ul>
                        </li>
                        @endforeach
                        @endisset
                    </ul>
                </div>
            </nav>
            <!--左侧导航结束-->
            <!--右侧部分开始-->
            <div id="page-wrapper" class="gray-bg dashbard-1">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i></a>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li class="dropdown">
                                
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="row content-tabs">
                    <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
                    </button>
                    <nav class="page-tabs J_menuTabs">
                        <div class="page-tabs-content">
                            <a href="javascript:;" class="active J_menuTab" data-id="{{url('admin/index/indexv1')}}">首页</a>
                        </div>
                    </nav>
                    <a class="roll-nav roll-right" href="javacript:void(0);" id="refresh-wrapper" style="right: 179px;"><i class="fa fa-refresh right_tool_icon"></i>
                    </a>
                    <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
                    </button>
                    <a href="{{url('admin/login/logout')}}" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>
                </div>
                <!-- 页面主体 -->
                <div class="row J_mainContent" id="content-main">
                     <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="{{url('admin/index/indexv1')}}" frameborder="0" data-id="{{url('admin/index/indexv1')}}" seamless>
                     </iframe>
                </div>
                <!-- 页面主体 -->
            <div class="footer">
                <div class="pull-right">&copy; 2019 <a href="" target="_blank">{{$config->config_title}}</a></div>
            </div>
            </div>
            <!--右侧部分结束-->
        </div>
    </body>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#refresh-wrapper").click(function () {
                var $currentIframe = $("#content-main iframe:visible");
                $currentIframe[0].contentWindow.location.reload();
                return false;
            }); 
        });
    </script>
@endsection

