@extends('admin.public.header')
@section('body')
	<style>
		*{
			margin:0px;
			padding: 0px;
		}
		.top-box{
			display: grid;
			grid-template-columns: repeat(3, 230px);
			margin-top:20px;
		}
		.item{
			border: 1px solid black;
			margin-left: 30px;
		}
		.bottom-box{
			display: grid;
			grid-template-columns: repeat(3, 230px);
			margin-top:20px;
		}
		.image-left{
			float:left;
			width:60px;
			height: 60px;
			margin:10px 8px;
		}
		.font-box{
			display: grid;
			grid-template-rows:repeat(2, 40px);
		}
		.font-title{
			color:#9d9d9d;
			font-size: 16px;
			line-height: 55px;
		}
		.font-number{
			font-size: 18px;
			color:#565656;
		}
	</style>
	<body class="gray-bg" id="vue">
	    <div class="wrapper wrapper-content" >
			<div class="top-box">
				<div class="item">
					<div><img src="/admin/img/money.png" class="image-left"></div>
					<div class="font-box">
						<div class="font-title">用户总数</div>
						<div class="font-number">{{$result['user_number']}}</div>
					</div>
				</div>
				<div class="item">
					<div><img src="/admin/img/money.png" class="image-left"></div>
					<div  class="font-box">
						<div class="font-title">员工总数</div>
						<div class="font-number">{{$result['job_number']}}</div>
					</div>
				</div>
				<div class="item">
					<div><img src="/admin/img/money.png" class="image-left"></div>
					<div  class="font-box">
						<div class="font-title">店铺总数</div>
						<div class="font-number">{{$result['shop_number']}}</div>
					</div>
				</div>
			</div>

			<div class="bottom-box">
				<div  class="item">
					<div><img src="/admin/img/money.png" class="image-left"></div>
					<div  class="font-box">
						<div class="font-title">日缴费金额</div>
						<div class="font-number">{{$result['day_rant_money']}}</div>
					</div>
				</div>
				<div  class="item">
					<div><img src="/admin/img/money.png" class="image-left"></div>
					<div class="font-box">
						<div class="font-title">月缴费金额</div>
						<div class="font-number">{{$result['month_rant_money']}}</div>
					</div>
				</div>
				<div  class="item">
					<div><img src="/admin/img/money.png" class="image-left"></div>
					<div class="font-box">
						<div class="font-title">总缴费金额</div>
						<div class="font-number">{{$result['rant_money_number']}}</div>
					</div>
				</div>
			</div>
	    </div>
	</body>

@endsection
<script type="text/javascript" src="/admin/js/vue.js"></script><!-- 选择按钮 -->
<script>
	var vue =  new Vue({
		el:"vue",
		delimiters : ['[[', ']]'],
		data(){
			return {
				user_number:999,
				job_number:999,
				shop_name:999,
				day_money:0,
				month_money:1000,
				sum_money:9999,
			}
		},
		async created(){

		}
	 })
</script>