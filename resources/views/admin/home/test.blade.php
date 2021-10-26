@extends('admin.public.header')
@section('body')
    <script>
        $.post("http://www.jnhmarket.cn/api/api/index/index",function (res) {
            console.log(res)
        })
    </script>
@endsection

