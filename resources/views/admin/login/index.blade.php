<html>
<head>
    <meta charset="UTF-8"/>
    <title>{{$config->config_title}}</title>
    <meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge"/>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta name="robots" content="noindex,nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="{{$config->config_keywords}}">
    <meta name="description" content="{{$config->config_desc}}">
    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="/admin/img/favicon.ico">
    <link href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/css/font-awesome.min93e3.css" rel="stylesheet" type="text/css">
    <link href="/admin/css/login.css" rel="stylesheet">
    <script> 
         if (window.parent != window) 
         { 
             window.top.location.href = location.href; 
         } 
    </script>
</head>
<body>
<div class="wrap">
    <div class="container">
        <div class="row">
            <div class="login-div">
                <div class="logo"><img src="/admin/img/login.png"/></div>              
                <form>
                    <div class="form-group">
                        <input type="text" id="input_username" class="form-control" name="username"
                               placeholder="账号" title="账号"
                               value="" data-rule-required="true" data-msg-required=""/>
                    </div>
                    <div class="form-group">
                        <input type="password" id="input_password" class="form-control" name="password"
                               placeholder="密码" title="密码" data-rule-required="true"
                               data-msg-required=""/>
                    </div>
                    <div class="form-group">
                        <button type="button" data-loadingmsg="登录" id="login">登录</button>
                    </div>
                </form>              
            </div>
            <div class="login_txt">
                <h5>技术支持：广州市正解互动设计有限公司</h5>
                <p style="font-size:12px;">公司地址：广州市海珠区新港东路世港国际（海珠创意园）B栋 701-702 、 707-708</p>
                <p style="font-size:12px;">电话：020-28296445  18027360580</p>
            </div>
        </div>

    </div>
</div>
</body>
<script src="/admin/js/jquery.min.js?v=2.1.4"></script>
<script src="/admin/js/layer/layer.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#login").click(function(){
            var username = $("#input_username").val();
            var password = $("#input_password").val();
            if (username==="") {
                layer.msg("账号不能为空",{icon:5});
                return false;
            }else if(password===""){
                layer.msg("密码不能为空",{icon:5});
                return false;
            }else{
                var data = {'admin_name':$("#input_username").val(),'admin_pwd':$("#input_password").val()}
                $.ajax({
                    type:"post",
                    headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{url('admin/login/login')}}",
                    async: false,
                    data:data,
                    dataType:'json',
                    success:function(res){ 
                        if(res.code === 1){
                            layer.msg(res.msg,{icon:6});
                            setTimeout(function(){
                                window.location.href="{{url('admin/index/index')}}";
                            },2000);
                        }else{
                            layer.msg(res.msg,{icon:5});
                            return false;
                        }
                    },
                    error:function(res){
                        layer.msg("服务器出错!",{icon:5});
                    }
                });
            }
        });
    });
</script>
</html>
