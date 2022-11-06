@extends('admin.layouts.__default')
@section('content')
    <div class="block shadow" id="breadcrumb">
        <a href="{{ url('/admin') }}">首页</a> - <a href="{{ url('/admin/category') }}">分类</a> - <span>添加</span>
    </div>
    <form name="form" id="form">
        <div class="block shadow mb-3">
            <div class="mb-3 form-control-row form-control-row-sm">
                <label for="parent_id" class="col-form-label"><span>*</span> 父分类</label>
                <div class="form-control-wrap">
                    <select class="form-select" aria-label="Default select example" id="parent_id" name="parent_id">
                        <option selected value="0">顶级</option>
                    </select>
                    <span class="form-control-msg"></span>
                </div>
                <div class="form-control-addon"></div>
            </div>
            <div class="mb-3 form-control-row form-control-row-sm">
                <label for="name" class="col-form-label"><span>*</span> 名称 </label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="name" name="name" placeholder=""/>
                    <span class="form-control-msg"></span>
                </div>
                <div class="form-control-addon">2到50个字符，汉字，英文字母，数字，下划线</div>
            </div>
            <div class="mb-3 form-control-row form-control-row-sm">
                <label for="slug" class="col-form-label"><span>*</span> slug</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="slug" name="slug">
                    <span class="form-control-msg"></span>
                </div>
                <div class="form-control-addon">2到50个字符,只能是字母/数字/下划线</div>
            </div>
            <div class="mb-3 form-control-row form-control-row-sm">
                <label for="model_id" class="col-form-label"><span>*</span> 所属模型</label>
                <div class="form-control-wrap">
                    <select class="form-select" aria-label="Default select example" id="model_id" name="model_id">
                        <option selected value="4">文章</option>
                    </select>
                    <span class="form-control-msg"></span>
                </div>
                <div class="form-control-addon"></div>
            </div>
            <div class="mb-3 form-control-row form-control-row-sm">
                <label for="cover" class="col-form-label">封面</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="cover" name="cover">
                    <span class="form-control-msg"></span>
                </div>
                <div class="form-control-addon"></div>
            </div>
            <div class="mb-3 form-control-row">
                <label for="status" class="col-form-label">是否开启 </label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" checked>
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
    @if ($model)
        <div class="menu-item" v-for="item in nav">
            <a href="#" class="menu-item-link"><span>@{{ item.name }}</span><i class="fa fa-caret-down" aria-hidden="true"></i></a>
            <ul class="sub-menu">
                <li><a :href="'{{ url('/admin/content_') }}' + item.table_name">列表</a></li>
                <li><a :href="'{{ url('/admin/content_') }}' + item.table_name + '/add'" class="active">添加</a></li>
                <li v-if="item.open_category"><a :href="'{{ url('/admin/category_') }}' + item.table_name">分类</a></li>
            </ul>
        </div>
    @else
        <div class="menu-item">
            <a href="#" class="menu-item-link"><span>模型</span><i class="fa fa-caret-down" aria-hidden="true"></i></a>
            <ul class="sub-menu">
                <li><a href="{{ url('/admin/model') }}">列表</a></li>
                <li><a href="{{ url('/admin/model/add') }}">添加</a></li>
            </ul>
        </div>
        <div class="menu-item">
            <a href="#" class="menu-item-link"><span>分类</span><i class="fa fa-caret-down" aria-hidden="true"></i></a>
            <ul class="sub-menu">
                <li><a href="{{ url('/admin/category') }}">列表</a></li>
                <li><a href="{{ url('/admin/category/add') }}" class="active">添加</a></li>
            </ul>
        </div>
    @endif
@endsection
@section('script')
<script>
    $(function(){
        vm.getNav('{{ url('/api/admin/content/nav') }}')

        // submit form
        $('#submit').bind('click', function(){
            $('.form-control-msg').text('').hide()
            // 前端验证
            let hasError = false;
            if (isEmpty($('#name').val())) {
                $('#name').next().text('名称不能为空').show();
                hasError = true ;
            }
            if (isEmpty($('#slug').val())) {
                $('#slug').next().text('slug不能为空').show();
                hasError = true ;
            }
            if (hasError)
                return;

            $(this).attr('disabled', true)
            $.ajax({
                url: "{{ url('/api/admin/category/create') }}",
                processData: false,
                method: 'post',
                dataType: 'json',
                data: $('#form').serialize(),
                success: function(res, status){
                    // 验证失败
                    if (res.code == 422 && res.errors) {
                        $.each(res.errors, function(k,v){
                            k = k.replaceAll(".", '_')
                            $('#' + k).next().text(v[0]).show();
                        })
                        // 登录失败
                    } else if (res.code == 200) {
                        alert('添加成功');
                        window.location.href = '{{ url('/admin/category') }}';
                    }
                    $('#submit').attr('disabled', false)
                },
                stop: function(){
                    $('#submit').attr('disabled', false)
                }
            });
        });
    })
</script>
@endsection
