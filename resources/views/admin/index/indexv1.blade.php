@extends('admin.public.header')
@section('body')

	<body class="gray-bg">
	    <div class="wrapper wrapper-content">
	        <div style="width:90%;height:500px;margin:0 auto;margin:20px;background:#fff;border:1px solid #999999">
		      <div style="width:100%;padding:10px;border-bottom:1px solid #999999">
		        <h4>系统信息</h4>
		      </div>
		        <div style="padding:30px;width:100%">
			        <div style="width:90%;font-size:16px;border-bottom:1px dashed #999999;padding:20px">
			          框架信息：Laravel6.0
			        </div>
			        <div style="width:90%;font-size:16px;border-bottom:1px dashed #999999;padding:20px">
			          服务器操作系统：{{$system}}
			        </div>
			        <div style="width:90%;font-size:16px;border-bottom:1px dashed #999999;padding:20px">
			          运行环境：{{$webServer}}
			        </div>
			        <div style="width:90%;font-size:16px;border-bottom:1px dashed #999999;padding:20px">
			          PHP版本：{{$php}}
			        </div>
			        <div style="width:90%;font-size:16px;border-bottom:1px dashed #999999;padding:20px">
			          MYSQL版本：{{$mysql}}
			        </div>
			        <div style="width:90%;font-size:16px;border-bottom:1px dashed #999999;padding:20px">
			          系统设计和维护：广州市正解互动设计有限公司
			        </div>
		    	</div>
			</div>
	    </div>
	</body>

@endsection