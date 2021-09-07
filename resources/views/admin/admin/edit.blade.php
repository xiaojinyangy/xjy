@extends('admin.public.header')
@section('body')
 <!-- 百度 插件 start -->
    <link rel="stylesheet" type="text/css" href="/admin/css/webuploads.css">
 <!-- 百度 插件 end -->
	<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                	<div class="ibox-title">
                        <h5>修改管理员信息</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{url('/admin/admin/postedit/'.$admin->admin_id)}}" method="post" class="form-horizontal js-ajax-form m-t">
                            @csrf
                            <div class="form-group">
                                <label class="col-sm-3 control-label">用户名：</label>
                                <div class="col-sm-8">
                                    <input name="admin_name" type="text" class="form-control" value="{{$admin->admin_name}}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">管理员头像：</label>
                                <div class="col-md-6 col-sm-10">
                                    <div id="uploader" class="wu-example">
                                       <!--用来存放文件信息-->
                                       <div id="thelist" class="uploader-list"></div>
                                       <div class="btns">
                                          <div id="picker" class="admin_img" >选择文件</div>
                                          <input type="hidden" name="admin_img" class="imgs" value="{{$admin->admin_img}}" >
                                       </div>
                                    </div>
                                    <!-- 文件預覽 -->
                                    <div id="admin_img">
                                        @if($admin->admin_img != null)
                                          <div class="de_all" id="contain">
                                            <div id="" class="file-item thumbnail styles" >
                                                  <img src="{{$admin->admin_img}}" onclick="imagePreviewDialog(this.src);" >
                                            </div>
                                            <span class="btn btn-danger admin_imgs">delete</span>
                                          </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
              								<label class="col-sm-3 control-label">等级：</label>
              								<div class="col-md-6 col-sm-10">
                                <label class="radio-inline i-checks">
                                        <input type="radio" name="admin_level" value="2" {{$admin->admin_level == 2 ? 'checked':''}}> 管理员
                                </label>
              								</div>
              							</div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">密码：</label>
                                <div class="col-sm-8">
                                    <input name="admin_pwd" type="password" class="form-control" placeholder="不修改密码请忽略！" value="" />
                                </div>
                            </div>
              							<div class="form-group">
              								<label class="col-sm-3 control-label" >状态：</label>
              								<div class="col-md-6 col-sm-10">
                                <label class="radio-inline i-checks">
                                        <input type="radio" name="admin_show" value="1" {{$admin->admin_show == 1 ? 'checked':''}}> 启用
                                </label>
                                <label class="radio-inline i-checks">
                                        <input type="radio" name="admin_show" value="2" {{$admin->admin_show == 2 ? 'checked':''}}> 禁用
                                </label>
              								</div>
              							</div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-3">
                                    @if( authchecks('admin/admin/postedit') )
                                    <button class="btn btn-primary js-ajax-submit" type="submit">保存</button>
                                    @endif
                                    <a class="btn btn-default" href="{{url('/admin/admin/index')}}">返回</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="/admin/js/admin.js"></script>
<!-- 百度插件 satrt -->
<script type="text/javascript" src="/webuploader/webuploader.js"></script> 
<script type="text/javascript">
      jQuery(function() {
            var  uploader;
            uploader =WebUploader.create({
                   resize: true, // 不压缩image     
                   swf: '/webuploader/Uploader.swf',// swf文件路径    
                   server: "{{url('admin/webuploads/index')}}", // 文件接收服务端。 
                   pick: '.admin_img',// 选择文件的按钮。可选。内部根据当前运行是创建，可能是input元素，也可能是flash.
                   chunked: true,//允许分片上传
                   chunkSize:2*1024*1024,//每个分片大小
                   auto: true,//是否自动上传
                   duplicate:true,//去除重复
                   multiple:false, //单个文件上传 多个为true
                   fileNumLimit:1,//上传文件个数限制  
                   fileSingleSizeLimit:20*1024*1024, //单个文件大小限制  20M
                   threads:1,//顺序上传 不给这个的话 上传顺序会打乱
                   accept: {
                    title: '文字描述',//文字描述
                    extensions: 'png,jpeg,jpg,gif',//上传文件后缀
                    mimeTypes: 'image/*,application/*'//上传文件类型
                   }
            }); 
            uploader.on( 'fileQueued', function( file ) { //文件加入队列后触发
                 var $list = $("#admin_img"),
                 $li = $(
                 '<div class="de_all" id="contain" style="display:inline-block;">'+'<div id="' + file.id + '" class="file-item thumbnail styles">' + '<img onclick="imagePreviewDialog(this.src);">' + '</div>'+'<span class="btn btn-danger admin_imgs">delete</span></div>'
                 ),
                 $img = $li.find('img');         
                 // $list为容器jQuery实例
                 $list.append( $li );  
                 // 创建缩略图
                 uploader.makeThumb( file, function( error, src ) { //src base_64位
                     if(error){
                         $img.replaceWith('<span>不能预览</span>');
                         return;
                     }
                     $img.attr( 'src', src );
                 }, 100, 100 ); //100x100为缩略图尺寸
            });
             
            //csrf传参
            uploader.on('uploadBeforeSend',function(object,data,header){
                data._token = "{{ csrf_token() }}";
            });

            // 文件上传过程中创建进度实时显示。
            uploader.on('uploadProgress', function (file, percentage) {
               var $li = $( '#'+file.id ),
               $percent = $li.find('.progress .progress-bar');
                // 避免重复创建
                if ( !$percent.length ) {
                    $percent = $('<div class="progress progresss progress-striped active">' +
                      '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                      '</div>' +
                    '</div>').appendTo( $li ).find('.progress-bar');
                }

                $percent.css( 'width', percentage * 100 + '%' );
            });
            //失败执行
            uploader.on( 'uploadError', function( file ) {
            });

            // 文件上传成功
            var arrs=[];
            uploader.on( 'uploadSuccess', function( file, res ) {
                  $("input[name='admin_img']").val(res.filePaht);
            });
            
            //删除
            $(document).on('click','.admin_imgs',function(){
                   //先拿到要删除的下标
                   var i=$(".admin_imgs").index(this);
                   //先获取文件删除的id 这个是上传的时候就生成了
                   var fileid=$(this).prev().attr('id');
                   //删除被点击预览图
                   $(this).parent().remove();
                   // 拿到隐藏域 img的值
                   var imgs_str =  $("input[name='admin_img']").val();
                   //拿到需要被删除的 图片真实路径
                   var img = imgs_str;
                   //再赋值回去隐藏域
                   $("input[name='admin_img']").val('');
                   //这个是插件的id 删除
                   if(fileid){
                     uploader.removeFile(fileid, true);
                   }
                   //再把前面拿到的需要被删除的图片 真实路径 AJAX请求删除真实文件
                   $.ajax({
                         url:"{{url('/admin/webuploads/del_file')}}",
                         type:"post",
                         dataType:"json",
                         data:{
                          file_path:img
                         },
                         success:function(data){
                            console.log(data);
                         }
                   })
            })             
      });
</script>
<!-- 百度插件 end -->
@endsection