@extends('admin.layouts.__default')
@section('content')
    <div class="block shadow" id="breadcrumb">
        <a href="{{ url('/admin') }}">首页</a> - <a href="{{ url('/admin/model') }}">内容</a> - <span>添加</span>
    </div>
    <form name="form" id="form">
        <div class="block shadow mb-3">
            <div class="mb-3 form-control-row form-control-row-sm">
                <label for="name" class="col-form-label"><span>*</span> 名称 </label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="name" name="name" placeholder=""/>
                    <span class="form-control-msg"></span>
                </div>
                <div class="form-control-addon">2到50个字符，汉字，英文字母，数字，下划线</div>
            </div>
            <div class="mb-3 form-control-row form-control-row-sm">
                <label for="table_name" class="col-form-label"><span>*</span> 表名</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="table_name" name="table_name">
                    <span class="form-control-msg"></span>
                </div>
                <div class="form-control-addon">2到50个字符,只能是字母/数字/下划线</div>
            </div>
            <div class="mb-3 form-control-row form-control-row-md">
                <label for="description" class="col-form-label">描述 </label>
                <div class="form-control-wrap">
                     <textarea class="form-control" id="description" name="description" rows="3" maxlength="255"></textarea>
                    <span class="form-control-msg"></span>
                </div>
                <div class="form-control-addon">最多255个字符</div>
            </div>
            <div class="mb-3 form-control-row">
                <label for="status" class="col-form-label">是否开启 </label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" checked>
                </div>
            </div>
            <div class="mb-3 form-control-row">
                <label for="open_category" class="col-form-label">支持分类 </label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="open_category" name="open_category" checked>
                </div>
            </div>
            <div class="mb-3 form-control-row">
                <label for="submit" class="col-form-label"></label>
                <div class="">
                    <button type="button" id="submit" class="btn btn-primary">提交</button>
                </div>
            </div>
        </div>
    </form>

@endsection()
@section('menu')
    <div class="menu-item" v-for="item in nav">
        <a href="#" class="menu-item-link"><span>@{{ item.name }}</span><i class="fa fa-caret-down" aria-hidden="true"></i></a>
        <ul class="sub-menu">
            <li><a :href="'{{ url('/admin/content_') }}' + item.table_name">列表</a></li>
            <li><a :href="'{{ url('/admin/content_') }}' + item.table_name + '/add'" class="active">添加</a></li>
            <li v-if="item.open_category"><a :href="'{{ url('/admin/category_') }}' + item.table_name">分类</a></li>
        </ul>
    </div>
@endsection
@section('script')
<script>
    $(function(){
        vm.getNav('{{ url('/api/admin/content/nav') }}')
    })
</script>
@endsection
