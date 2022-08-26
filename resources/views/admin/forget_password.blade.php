@extends('admin.layouts.__entrance')
@section('content')
    <div class="block block-title">
        <h3 class="">找回密码</h3>
    </div>
    <div class="block  entrance-block mb-1">
        <form>
            <div class="mb-3">
                <input type="text" class="form-control" id="username" placeholder="账户/邮箱"/>
            </div>
            <div class="d-grid">
                <button class="btn btn-primary" type="button">发送</button>
            </div>
        </form>
    </div>
    <div class="block block-footer">
        <p><a href="/admin/login">登录</a></p>
    </div>
@endsection
