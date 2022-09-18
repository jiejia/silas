@extends('admin.layouts.__entrance')
@section('content')
    <div class="block block-title">
        <h3 class="">登录</h3>
    </div>
    <div class="block shadow entrance-block mb-1">
        <form name="form" id="form">
            <div class="mb-3 form-control-wrap">
                <input type="email" class="form-control" id="email" name="email" placeholder="账户/邮箱"/>
                <span class="form-control-msg"></span>
            </div>
            <div class="mb-2 form-control-wrap">
                <input type="password" class="form-control" id="password" name="password" placeholder="密码"/>
                <span class="form-control-msg"></span>
            </div>
            <div class="mb-2 form-control-wrap">
                <input class="form-check-input" type="checkbox" value="" id="remember"/>
                <label class="form-check-label" for="remember">
                    &nbsp;记住登录状态
                </label>
            </div>
            <div class="d-grid">
                <button class="btn btn-primary" type="button" id="submit">登录</button>
            </div>
        </form>
    </div>
    <div class="block block-footer">
        <p><a href="/admin/forget-password">忘记密码?</a></p>
    </div>
@endsection
@section('script')
<script type="text/javascript">
$(function(){
    $('.form-control').bind('click', function(){
        $(this).next().hide();
    });
    $('#submit').bind('click', function(){
        // 前端验证
        let hasError = false;
        if (isEmpty($('#email').val())) {
            $('#email').next().text('邮箱不能为空').show();
            hasError = true;
        }
        if (! isEmail($('#email').val())) {
            $('#email').next().text('邮箱格式错误').show();
            hasError = true;
        }
        if (isEmpty($('#password').val())) {
            $('#password').next().text('密码不能为空').show();
            hasError = true;
        }
        if (hasError)
            return;

        $(this).attr('disabled', true)
        $.ajax({
            url: "{{ url('/api/admin/auth/login') }}",
            processData: false,
            method: 'post',
            dataType: 'json',
            data: $('#form').serialize(),
            success: function(res, status){
                // 验证失败
                if (res.code == 422 && res.errors) {
                    $.each(res.errors, function(k,v){
                         $('#' + k).next().text(v).show();
                    })
                // 登录失败
                } else if (res.code == 401) {
                    alert('用户名或密码错误')
                // 登录成功
                } else if (res.code == 200) {
                    localStorage.setItem('sila_user',   JSON.stringify(res.data.user))
                    localStorage.setItem('sila_token', res.data.token)
                    window.location.href = "{{ url('/admin/') }}"

                }
                $('#submit').attr('disabled', false)
            },
            error: function(){
                $('#submit').attr('disabled', false)
            }
        });
    });
})
</script>
@endsection
