<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous"/>
    <link href="/assets/admin/lib/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" crossorigin="anonymous"/>
    <link href="/assets/admin/css/style.css" rel="stylesheet" crossorigin="anonymous"/>
    <link href="/assets/admin/css/theme.css" rel="stylesheet" crossorigin="anonymous"/>
    @yield('style')
</head>
<body>
<div id="app" class="sa-container">
    <header>
        <div id="logo">
            <h1><a href="#">后台管理</a></h1>
        </div>
        <div id="nav">
            <ul>
                <li><a href="{{ url('/admin') }}"@if($currentNav == 'home') class="active"@endif>首页</a></li>
                <li><a href="{{ url('/admin/content') }}"@if($currentNav == 'content') class="active"@endif>内容管理</a></li>
                <li><a href="{{ url('/admin/model') }}"@if($currentNav == 'model') class="active"@endif>模型管理</a></li>
                <li><a href="{{ url('/admin/setting') }}"@if($currentNav == 'setting') class="active"@endif>设置</a></li>
            </ul>
        </div>
        <div id="user-menu">
            <ul>
                <li><a href="{{ url('/admin/user/setting') }}">@{{ silaUser.name }}</a></li>
                <li><a href="javascript:;" id="logout">退出</a></li>
            </ul>
        </div>
    </header>
    <div id="main">
        <aside>
            <div id="menu">
                @yield('menu')
            </div>
        </aside>
        <main>
            @yield('content')
        </main>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="{{ asset('/assets/admin/js/validator.js') }}"></script>
<script src="https://unpkg.com/vue@3"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
<script type="text/javascript">
    //仅限于包含`&、<、>、'`的文本转换
    function stringToEntity(str){
        let div=document.createElement('div');
        div.innerText=str;
        div.textContent=str;
        let res=div.innerHTML;
        // console.log(str,'->',res);
        return res;
    }
    function entityToString(entity){
        let div=document.createElement('div');
        div.innerHTML=entity;
        let res=div.innerText||div.textContent;
        // console.log(entity,'->',res);
        return res;
    }

    const { createApp } = Vue
    const app = createApp({
        data() {
            return {
                silaUser: null,
                silaToken: null,
                listData: {},
                listSearchParams: {},
                pagination: [],
                detail: {}
            }
        },
        created() {
            // 验证是否登录
            this.silaToken = localStorage.getItem('sila_token')
            this.silaUser = JSON.parse(localStorage.getItem('sila_user'))
            if (! this.silaToken || ! this.silaUser) {
                window.location.href = "{{ url('/admin/login') }}"
            } else {
                $('#app').show();
            }
        },
        beforeMount() {
            // 默认ajax请求
            $.ajaxSetup({
                headers: {
                    Authorization: "Bearer " + this.silaToken
                },
                error: function(res, status){
                    // 没有权限默认跳转到登录页面
                    if (res.status == 401) {
                        localStorage.clear()
                        alert('登录已过期')
                        window.location.href = "{{ url('/admin/login') }}"
                    }
                }
            })
        },
        mounted() {
            // 退出
            $("#logout").bind('click', function(){
                $.ajax({
                    url: "{{ url('/api/admin/auth/logout') }}",
                    processData: false,
                    method: 'post',
                    dataType: 'json',
                    success: function(res, status){
                        localStorage.clear()
                        window.location.href = "{{ url('/admin/login') }}"
                    }
                });
            })

            // 侧边菜单 todo 本地存储开合状态
            $('.menu-item-link').bind('click', function(){
                let next = $(this).next()
                if (next.css('display') == 'none') {
                    $(this).children('i').attr('class', 'fa fa-caret-right')
                    next.slideDown(10)
                } else {
                    $(this).children('i').attr('class', 'fa fa-caret-down')
                    next.slideUp(10)
                }
            })

            // 自动关闭提示
            $('.form-control').bind('click', function(){
                $(this).next().hide();
            });
            $('.form-control').next().bind('click', function(){
                $(this).hide();
            });

            // 列表全选
            $("#id-check-all").bind('change', function(){
                if ($("#id-check-all").prop('checked') == true) {
                    $('input[name="id-check[]"]').each(function (i, e){
                        $(e).attr('checked', true)
                    })
                } else {
                    $('input[name="id-check[]"]').each(function (i, e){
                        $(e).attr('checked', false)
                    })
                }
            })
            @yield('mounted')
        },
        methods: {
            // 获取列表
            getList(link) {
                this.listSearchParams.per_page = $("#per-page").val()
                $.ajax({
                    url: link,
                    method: 'post',
                    data: this.listSearchParams,
                    success: function(res, status){
                        if (res.code == 200) {
                            for (let k in res.data.links)   {
                                res.data.links[k]['label'] = entityToString(res.data.links[k]['label'])
                            }
                            vm.listData = res.data
                        }
                    },
                    stop: function(){
                    }
                })
            },
            // 获取详情
            getDetail(link) {
                $.ajax({
                    url: link,
                    method: 'post',
                    data: {},
                    success: function(res, status){
                        if (res.code == 200) {
                            vm.detail = res.data
                        }
                    },
                    stop: function(){
                    }
                })
            }
            @yield('methods')
        }
    });
    const vm = app.mount('#app')
</script>
<script>
$(function(){

})
</script>
@yield('script')
</body>
</html>
