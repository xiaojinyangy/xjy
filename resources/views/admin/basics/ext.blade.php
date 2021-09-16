@extends('admin.public.header')
@section('body')
<form class="layui-form layui-form-pane" id="form">
        <div class="form-group">
            <label class="col-sm-3 control-label">附加费设置：</label>
            <div class="col-md-8 col-sm-10">
                <table class="table table-striped table-hover ">
                    <thead>
                    <tr>
                        <th style="text-align: left;">附加费名称</th>
                        <th style="text-align: left;">价格</th>
                        <th style="text-align: left;">操作</th>
                    </tr>
                    </thead>
                    <tbody id="first">
                    @foreach($result as $key=>$v)
                    <tr id="add{{$key}}">
                        <input type="hidden" value="{{$v['id']}}" name=id>
                        <td style="text-align: center;"><input type="text" name="rant_title"
                                                               class="form-control" value="{{$v['rant_title']}}"
                                                               placeholder="请输入附加费名称"/></td>
                        <td style="text-align: center;"><input name="rant_money"
                                                               type="number"
                                                               class="form-control" value="{{$v['rant_money']}}"
                                                               placeholder="请输入价格"/></td>
                        @if($key == 0 )
                        <td style="text-align: center;">
                            <a class="btn btn-primary" id="add">+</a>
                        </td>
                         @else
                            <td style="text-align: center;">
                                <a class="btn btn-primary del" id={{$key}}>-</a>
                            </td>
                        @endif
                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    <div class="layui-form-item" style="text-align: center">
        <a  class="layui-btn" id="submit" >保存</a>
    </div>
</form>
<script>
    var n = 1;
    $('#add').click(function () {
        n++;
        var html = '';
        html += '<tr' + ' id="add' + n + '"' + '>\n' +
            '                                            <td style="text-align: center;"><input  name="rant_title" type="text"\n' +
            '                                                                                   class="form-control" value=""\n' +
            '                                                                                   placeholder="请输入附加费名称"/></td>\n' +
            '                                            <td style="text-align: center;"><input  name="rant_money"  type="number"\n' +
            '                                                                                   class="form-control" value=""\n' +
            '                                                                                   placeholder="请输入价格"/></td>\n' +
            '                                            <td style="text-align: center;">\n' +
            '                                                <a class="btn btn-primary del" id=' + n + '>-</a>\n' +
            '\n' +
            '                                            </td>\n' +
            '                                        </tr>';
        $('#first').append(html);
    });
    $("#first").on('click', '.del', function () {
        var val = $(this).attr('id');
        $("#add" + val).remove();
    });
    $("#submit").click(function () {
            $.post("{{url('admin/basics/rant_ext')}}",{data:$("#form").serializeArray()},function (res) {

            })
    })
</script>
@endsection