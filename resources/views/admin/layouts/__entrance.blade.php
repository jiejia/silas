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
    <link href="/assets/admin/css/style.css" rel="stylesheet" crossorigin="anonymous"/>
    <link href="/assets/admin/css/theme.css" rel="stylesheet" crossorigin="anonymous"/>
    @yield('style')
</head>
<body class="entrance" id="app">
<div class="entrance-container">
    @yield('content')
</div>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="{{ asset('/assets/admin/js/validator.js') }}"></script>
<script src="https://unpkg.com/vue@3"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
<script type="text/javascript">
    const { createApp } = Vue
    const app = createApp({
        data() {
            return {
                silaUser: null,
                silaToken: null
            }
        },
        created() {
            // 验证是否登录
            this.silaToken = localStorage.getItem('sila_token')
            this.silaUser = JSON.parse(localStorage.getItem('sila_user'))
            if (this.silaToken && this.silaUser) {
                window.location.href = "{{ url('/admin/') }}"
            } else {
                $('#app').show();
            }
        },
        mounted() {
            // 自动关闭提示
            $('.form-control').bind('click', function(){
                $(this).next().hide();
            });
            $('.form-control').next().bind('click', function(){
                $(this).hide();
            });
        }
    });
    const vm = app.mount('#app')
</script>
@yield('script')
</body>
</html>
