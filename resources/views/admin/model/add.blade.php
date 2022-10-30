@extends('admin.layouts.__default')
@section('content')
    <div class="block shadow" id="breadcrumb">
        <a href="{{ url('/admin') }}">首页</a> - <a href="{{ url('/admin/model') }}">模型</a> - <span>添加</span>
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
        <div v-for="(item, index) in listForm.controls" class="block shadow mb-3">
            <div style="font-size:20px;font-weight:bold">@{{ index + 1 }}</div>
             <div class="row mb-2">
                    <div class="col-md-3 form-control-wrap">
                        <label class="form-label">控件类型 <span>*</span></label>
                        <select class="form-select" aria-label="Default select example" :name="'fields[' + index + '][form_control]'" onchange="switchControl(this)">
                            <option value="text">文本行</option>
                            <option value="textarea">文本框</option>
                            <option value="editor">富文本编辑器</option>
                            <option value="select">下拉选择</option>
                            <option value="datetime">日期时间</option>
                            <option value="numeric">数字</option>
                            <option value="switch">开关</option>
                            <option value="slide">滑块</option>
                            <option value="city">城市</option>
                            <option value="color">颜色选择器</option>
                            <option value="file">文件上传/选择</option>
                        </select>
                        <span class="form-control-msg"></span>
                    </div>
                    <div class="col-md-3 form-control-wrap">
                        <label class="form-label">字段名称 <span>*</span></label>
                        <input type="text" class="form-control"  @click="hideValidMsg($event)" :name="'fields[' + index + '][name]'" :id="'fields_' + index + '_name'"/>
                        <span class="form-control-msg"></span>
                    </div>
                    <div class="col-md-3 form-control-wrap">
                        <label  class="form-label">表字段名 <span>*</span></label>
                        <input type="text" class="form-control" @click="hideValidMsg($event)" :name="'fields[' + index + '][table_field_name]'" :id="'fields_' + index + '_table_field_name'"/>
                        <span class="form-control-msg"></span>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">描述</label>
                        <input type="text" class="form-control" :name="'fields[' + index + '][comments]'" :id="'fields_' + index + '_comments'"/>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">是否可为空 <span>*</span></label>
                        <select class="form-select" :name="'fields[' + index + '][is_null]'" :id="'fields_' + index + '_is_null'" onchange="switchControl(this)">
                            <option value="1" selected>是</option>
                            <option value="0">否</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">默认值</label>
                        <input type="text" class="form-control" :name="'fields[' + index + '][default]'" :id="'fields_' + index + '_default'"/>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">长度</label>
                        <input type="number" class="form-control" :name="'fields[' + index + '][length]'" :id="'fields_' + index + '_length'" data-config-name="length" value="10"/>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">选择正则</label>
                        <select class="form-select form-control" aria-label="Default select example" data-config-name="valid_rule" :name="'fields[' + index + '][valid_rule]'" :id="'fields_' + index + '_valid_rule'">
                            <option selected>无</option>
                            <option value="1">Email</option>
                            <option value="1">手机号</option>
                            <option value="1">URL</option>
                            <option value="1">自定义正则</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">自定义正则</label>
                        <input type="text" class="form-control" :name="'fields[' + index + '][valid_rule]'" :id="'fields_' + index + '_valid_rule'" data-config-name="valid_rule"/>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">输入格式提示</label>
                        <input type="text" class="form-control" :name="'fields[' + index + '][valid_msg]'" :id="'fields_' + index + '_valid_msg'" data-config-name="valid_msg"/>
                    </div>

                    <div class="col-md-3 hidden">
                        <label class="form-label">类型</label>
                        <select class="form-select form-control" aria-label="Default select example" :name="'fields[' + index + '][config][select_type]'" :id="'fields_' + index + '_config.select_type'" data-config-name="select_type">
                            <option value="single">单选</option>
                            <option value="multiple">多选</option>
                        </select>
                    </div>
                    <div class="col-md-3 hidden">
                        <label class="form-label">选项来源</label>
                        <select class="form-select form-control" aria-label="Default select example" :name="'fields[' + index + '][config][select_source]'" :id="'fields_' + index + '_config.select_source'" data-config-name="select_source">
                            <option value="source">填写</option>
                            <option value="url">远程url</option>
                        </select>
                    </div>
                    <div class="col-md-6 hidden">
                        <label class="form-label">选项值/描述</label>
                        <textarea class="form-control" id="description" :name="'fields[' + index + '][config][select_options]'" :id="'fields_' + index + '_config_select_options'" rows="3" maxlength="255" data-config-name="select_options" placeholder="值:描述"></textarea>
                    </div>
                    <div class="col-md-6 hidden">
                        <label class="form-label">选项值/描述</label>
                        <input type="text" class="form-control" :name="'fields[' + index + '][config][select_options_url]'" :id="'fields_' + index + '_config_select_options_url'" value="" data-config-name="select_options_url"/>
                    </div>

                    <div class="col-md-3 hidden">
                        <label class="form-label">行</label>
                        <input type="number" class="form-control" :name="'fields[' + index + '][config][rows]'" :id="'fields_' + index + '_config_rows'" value="10" data-config-name="rows"/>
                    </div>
                    <div class="col-md-3 hidden">
                        <label class="form-label">列</label>
                        <input type="number" class="form-control" :name="'fields[' + index + '][config][cols]'" :id="'fields_' + index + '_config_cols'" value="10" data-config-name="cols"/>
                    </div>

                    <div class="col-md-3 hidden">
                        <label class="form-label">日期格式</label>
                        <input type="text" class="form-control" :name="'fields[' + index + '][config][date_format]'" :id="'fields_' + index + '_config_date_format'" value="Y-m-d H:i:s" data-config-name="date_format"/>
                    </div>
                </div>
            <div class="d-grid  col-1 mx-auto" style="text-align: right">
                <button class="btn btn-outline-secondary" type="button" onclick="removeField(this)">删除</button>
            </div>
        </div>

        <div class="block shadow mb-3">
            <div class="d-grid col-1 mx-auto">
                <button class="btn btn-primary add-field" type="button">添加</button>
            </div>
        </div>
    </form>

@endsection()
@section('menu')
    <div class="menu-item">
        <a href="#" class="menu-item-link"><span>模型</span><i class="fa fa-caret-down" aria-hidden="true"></i></a>
        <ul class="sub-menu">
            <li><a href="{{ url('/admin/model') }}">列表</a></li>
            <li><a href="{{ url('/admin/model/add') }}" class="active">添加</a></li>
        </ul>
    </div>
@endsection
@section('script')
<script>
    const controls = {
        "text": ["length", "valid_rule", "valid_msg"],
        "textarea": ["rows", "cols", "length", "valid_rule", "valid_msg"],
        "editor": [],
        "select": ["select_type", "select_source", "select_options"],
        "datetime": ["date_format"],
        "numeric": ["max"],
        "switch": [],
        "slide": ["max"],
        "city": [],
        "color": [],
        "file": [],
    }
    $(function(){
        vm.listForm.controls = [{}]
        $('#submit').bind('click', function(){
            $('.form-control-msg').text('').hide()
            // 前端验证
            let hasError = false;
            if (isEmpty($('#name').val())) {
                $('#name').next().text('名称不能为空').show();
                hasError = true ;
            }
            if (isEmpty($('#table_name').val())) {
                $('#table_name').next().text('表名不能为空').show();
                hasError = true ;
            }
            if (hasError)
                return;

            $(this).attr('disabled', true)
            $.ajax({
                url: "{{ url('/api/admin/model/create') }}",
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
                        window.location.href = '{{ url('/admin/model') }}';
                    }
                    $('#submit').attr('disabled', false)
                },
                stop: function(){
                    $('#submit').attr('disabled', false)
                }
            });
        });
        // 添加元素
        $('.add-field').bind('click', function(){
            vm.listForm.controls.push({});
        })
    })
    // 删除字段
    function removeField(obj)
    {
        $(obj).parent().parent().remove()
    }
    // 控件类型切换
    function switchControl(obj){
        let configs = controls[$(obj).val()]
        console.log(configs)
        $(obj).parent().parent().next().children().find(".form-control").each(function(i, v){
            console.log($(v).attr('data-config-name'))
            if (! configs.includes($(v).attr('data-config-name'))) {
                $(v).parent().hide()
            } else {
                $(v).parent().show()
            }
        });
    }
</script>
@endsection
