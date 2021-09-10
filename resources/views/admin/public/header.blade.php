<!DOCTYPE html>
<html>
<!-- Mirrored from www.zi-han.net/theme/hplus/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:16:41 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>@yield('title','后台管理')</title> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="@yield('keywords','后台管理')">
    <meta name="description" content="@yield('description','后台管理')">

    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <!--css-->
    
    <link rel="shortcut icon" href="/admin/img/favicon.ico">
    <link href="/admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/admin/css/animate.min.css" rel="stylesheet">
    <link href="/admin/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/admin/css/plugins/webuploader/webuploader.css">
    <link rel="stylesheet" type="text/css" href="/admin/css/demo/webuploader-demo.min.css">
    <link href="/admin/css/style.min.css?v=4.1.0" rel="stylesheet">
    <link href="/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/admin/js//layui/layui/css/layui.css" rel="stylesheet">
    <style type="text/css">
        .form-required {
            color: red;
        }
    </style>

    <!--js-->
    <script type="text/javascript">
        //全局变量
        var GV = {
            ROOT: "__ROOT__/",
            WEB_ROOT: "/",
            JS_ROOT: "admin/js/"
        };
    </script>
    <script type="text/javascript" src="/admin/js/jquery.min.js"></script>
    <script type="text/javascript" src="/admin/js/wind.js"></script>
    <script type="text/javascript" src="/admin/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/layer/layer.min.js"></script>
    <script type="text/javascript" src="/admin/js/hplus.min.js?v=4.1.0"></script>
    <script type="text/javascript" src="/admin/js/contabs.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/pace/pace.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/layer/laydate/laydate.js"></script><!-- 时间插件 -->
    <script type="text/javascript" src="/admin/js/plugins/iCheck/icheck.min.js"></script><!-- 选择按钮 -->
    <script type="text/javascript" src="/admin/js/vue.js"></script><!-- 选择按钮 -->
    <script type="text/javascript" src="/admin/js//layui/layui/layui.js"></script><!-- 选择按钮 -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>

</head>
    @yield('body')
    <!-- 弹窗提示 -->
    @include('myflash::notification')
<!-- Mirrored from www.zi-han.net/theme/hplus/form_validate.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:19:16 GMT -->
<script type="text/javascript">
    //CSRF 保护
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
</html>
