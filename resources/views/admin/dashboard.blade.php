@extends('admin.layouts.__default')
@section('content')
    <div class="block shadow" id="breadcrumb">
        <a href="#">首页</a> - <span>面板</span>
    </div>
@endsection()
@section('menu')
    <div class="menu-item">
        <a href="#" class="menu-item-link"><span>面板</span><i class="fa fa-caret-down" aria-hidden="true"></i></a>
        <ul class="sub-menu">
            <li><a href="#" class="active">文章1</a></li>
            <li><a href="#">文章1</a></li>
            <li><a href="#">文章1</a></li>
        </ul>
    </div>
@endsection
