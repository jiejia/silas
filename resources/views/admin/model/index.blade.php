@extends('admin.layouts.__default')
@section('content')
    <div class="block shadow" id="breadcrumb">
        <a href="{{ url('/admin') }}">首页</a> - <a href="{{ url('/admin/model') }}">模型</a> - <span>列表</span>
    </div>
    <div class="block shadow">
        <table class="table table-striped table-hover table-bordered">
            <thead>
            <tr>
                <th scope="col"> <input class="form-check-input" type="checkbox" id="id-check-all"/></th>
                <th scope="col">ID</th>
                <th scope="col">模型名</th>
                <th scope="col">表名</th>
                <th scope="col">描述</th>
                <th scope="col">操作</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in listData.data">
                <td><input class="form-check-input" type="checkbox" :value="item.id" name="id-check[]"/></td>
                <td>@{{ item.id }}</th>
                <td>@{{ item.name }}</td>
                <td>@{{ item.table_name }}</td>
                <td>@{{ item.description }}</td>
                <td>
                    <a :href="'{{ url('/admin/model/edit') }}/' + item.id">编辑</a> /
                    <a href="">查看</a> /
                    <a href="javascript:;" @click="deleteItems('{{ url('/api/admin/model/delete') }}', [item.id])">删除</a>
                </td>
            </tr>
            <tr v-if="listData.total==0"><td colspan="6" style="text-align:center">没有记录</td></tr>
            </tbody>
        </table>
        <nav  v-if="listData.total" aria-label="Page navigation" id="pagination">
            <div>

            </div>
            <ul class="pagination justify-content-center">
                <select class="form-select-sm" id="per-page" @change="getList(listData.path, this)">
                    <option value="15" selected>15条/页</option>
                    <option value="30">30条/页</option>
                    <option value="50">50条/页</option>
                    <option value="100">100条/页</option>
                </select> &nbsp;
                <template v-for="item in listData.links">
                    <template v-if="item.url != null">
                        <li class="page-item" :class="{active: item.active}">
                            <a class="page-link" href="javascript:;" @click="getList(item.url)">@{{ item.label }}</a>
                        </li>
                    </template>
                    <template v-else>
                        <li class="page-item disabled" :class="{active: item.active}">
                            <a class="page-link" href="javascript:;">@{{ item.label }}</a>
                        </li>
                    </template>
                </template>
            </ul>
        </nav>
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
    <div class="menu-item">
        <a href="#" class="menu-item-link"><span>分类</span><i class="fa fa-caret-down" aria-hidden="true"></i></a>
        <ul class="sub-menu">
            <li><a href="{{ url('/admin/category') }}">列表</a></li>
            <li><a href="{{ url('/admin/category/add') }}">添加</a></li>
        </ul>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    $(function(){
        vm.getList('{{ url('/api/admin/model/list') }}')
    })
</script>
@endsection
@section('methods')

@endsection
