@extends('admin.public.header')
@section('body')
<style type="text/css">
    .tables{

    }
    .tables tr{
        
    }
    .tables tr td{
        float: left;
        margin-left: 30px;
    }
</style>
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>权限分配</h5>
                    </div>
                    <div class="ibox-content">
                    <form action="{{url('/admin/authgroup/postallocate/'.$group_id)}}" method="post" class="form-horizontal js-ajax-form m-t forms" style="padding-bottom:30px;">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover " id="f3">
                                       @csrf
                                       @foreach($top as $vo)
                                        <tr>
                                            <td style="width: 10%;">
                                                <label class="checkbox-inline i-checks qwer" >
                                                    <input type="checkbox" name="rule_id[]"  {{in_array($vo['rule_id'],$authgroup)?'checked':''}}  value="{{$vo['rule_id']}}">{{$vo['rule_name']}}
                                                </label>
                                            </td>
                                            <td>
                                                <table class="tables">
                                                    <tr>
                                                        @isset($vo['secondary'])
                                                            @foreach($vo['secondary'] as $vos)
                                                                <td>
                                                                    <label class="checkbox-inline i-checks">
                                                                        <input type="checkbox" name="rule_id[]"  {{in_array($vos['rule_id'],$authgroup)?'checked':''}}  value="{{$vos['rule_id']}}">{{$vos['rule_name']}}
                                                                    </label>
                                                                </td>
                                                            @endforeach
                                                        @endisset
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="7" style="text-align: left;">
                                                <span  class="btn btn-primary select_all">全选</span>
                                                <span  class="btn btn-primary inverse_select">取消全选</span>
                                                @if( authchecks('admin/authgroup/postallocate') )
                                                <button type="submit" class="btn btn-success js-ajax-submit"  >分配选中的权限</button>
                                                @endif
                                                <a class="btn btn-danger" href="{{url('/admin/authgroup/index')}}">返回</a>
                                                <i style="color: red;margin-left: 15px;">注：当选择管理模块的权限时，这个管理模块的首选项必选。 &nbsp;&nbsp; 例：选择  菜单列表 ， 菜单管理 也需要选中。</i>
                                            </td>
                                        </tr>
                            </table>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="/admin/js/admin.js"></script>
<script>
    $(document).ready(function () {
        // 全选和取消全选 选择
        function selectall(sign){
            var testForm = document.getElementById('f3');
            var ipts = testForm.getElementsByTagName('input');
            if(sign){
                $('input[type="checkbox"]').iCheck('check');
            }else{
                $('input[type="checkbox"]').iCheck('uncheck');
            }
            return false;
        }

        //全选
        $(document).on('click','.select_all',function(){
            selectall(true);
        })
        //取消全选
        $(document).on('click','.inverse_select',function(){
            selectall(false);
        })  

        //行选
        $(".qwer").on('ifChecked', function(event) {
            var i=$(".qwer").index(this);
            $('.tables').eq(i).find('input').iCheck('check');
        });
        $(".qwer").on('ifUnchecked', function(event) {
            var i=$(".qwer").index(this);
            $('.tables').eq(i).find('input').iCheck('uncheck');
        });    
    });
</script>
@endsection