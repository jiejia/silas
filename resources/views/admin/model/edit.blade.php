@extends('admin.layouts.__default')
@section('content')
    <div class="block shadow" id="breadcrumb">
        <a href="{{ url('/admin') }}">首页</a> - <a href="{{ url('/admin/model') }}">模型</a> - <span>编辑</span>
    </div>
    <div class="block shadow">
        <form name="form" id="form">
            <div class="mb-3 form-control-row form-control-row-md">
                <label for="name" class="col-form-label"><span>*</span> 名称 </label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="name" name="name" placeholder="" :value="detail.name"/>
                    <span class="form-control-msg"></span>
                </div>
                <div class="form-control-addon">2到50个字符，汉字，英文字母，数字，下划线</div>
            </div>
            <div class="mb-3 form-control-row form-control-row-sm">
                <label for="table_name" class="col-form-label"><span>*</span> 表名</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="table_name" name="table_name" :value="detail.table_name"/>
                    <span class="form-control-msg"></span>
                </div>
                <div class="form-control-addon">2到50个字符,只能是字母/数字/下划线</div>
            </div>
            <div class="mb-3 form-control-row form-control-row-md">
                <label for="description" class="col-form-label">描述 </label>
                <div class="form-control-wrap">
                    <textarea class="form-control" id="description" name="description" rows="3" maxlength="255">@{{ detail.description }}</textarea>
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
                <label for="submit" class="col-form-label"></label>
                <div class="">
                    <button type="button" id="submit" class="btn btn-primary">提交</button>
                </div>
            </div>
        </form>
    </div>
@endsection()
@section('menu')
    <div class="menu-item">
        <a href="#" class="menu-item-link"><span>模型</span><i class="fa fa-caret-down" aria-hidden="true"></i></a>
        <ul class="sub-menu">
            <li><a href="{{ url('/admin/model') }}" class="active">列表</a></li>
            <li><a href="{{ url('/admin/model/add') }}">添加</a></li>
        </ul>
    </div>
@endsection
@section('script')
    <script>
        $(function(){
            vm.getDetail("{{ url('/api/admin/model/') . '/'. $id}}");

            $('#submit').bind('click', function() {
                // 前端验证
                let hasError = false;
                if (isEmpty($('#name').val())) {
                    $('#name').next().text('名称不能为空').show();
                    hasError = true;
                }
                if (isEmpty($('#table_name').val())) {
                    $('#table_name').next().text('表名不能为空').show();
                    hasError = true;
                }
                if (hasError)
                    return;

                $(this).attr('disabled', true)
                $.ajax({
                    url: "{{ url('/api/admin/model/update/') . '/' . $id }}",
                    processData: false,
                    method: 'post',
                    dataType: 'json',
                    data: $('#form').serialize(),
                    success: function (res, status) {
                        // 验证失败
                        if (res.code == 422 && res.errors) {
                            $.each(res.errors, function (k, v) {
                                $('#' + k).next().text(v).show();
                            })
                            // 登录失败
                        } else if (res.code == 200) {
                            alert('编辑成功');
                            window.location.href = '{{ url('/admin/model') }}';
                        }
                        $('#submit').attr('disabled', false)
                    },
                    stop: function () {
                        $('#submit').attr('disabled', false)
                    }
                });
            });
        })
    </script>
@endsection
