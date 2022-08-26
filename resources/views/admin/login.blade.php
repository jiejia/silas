@extends('admin.layouts.__entrance')
@section('content')
    <div class="block block-title">
        <h3 class="">登录</h3>
    </div>
    <div class="block entrance-block mb-1">
        <form>
            <div class="mb-3">
                <input type="text" class="form-control" id="username" placeholder="账户/邮箱"/>
            </div>
            <div class="mb-2">
                <input type="password" class="form-control" id="password" placeholder="密码"/>
            </div>
            <div class="mb-2">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"/>
                <label class="form-check-label" for="flexCheckDefault">
                    记住登录状态
                </label>
            </div>
            <div class="d-grid">
                <button class="btn btn-primary" type="button">登录</button>
            </div>
        </form>
    </div>
    <div class="block block-footer">
        <p><a href="/admin/forget-password">忘记密码?</a></p>
    </div>
@endsection
@section('script')
    <script type="text/javascript">

    </script>
@endsection
