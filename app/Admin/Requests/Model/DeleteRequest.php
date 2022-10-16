<?php

namespace App\Admin\Requests\Model;

use App\Common\Requests\Request;
use Illuminate\Validation\Rule;

class DeleteRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'ids' => [ 'required', 'array'],
            'ids.*' => ['required', 'exists:sila_models,id']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '模型名不能为空',
            'name.between' => '模型名应在2至50个字符',
            'name.unique' => '模型名已存在',
            'table_name.required' => '表名不能为空',
            'table_name.between' => '表名应在2至30个字符',
            'table_name.unique' => '表名已存在',
            'description.required' => '描述最多255个字符',
            'status.in' => '状态只能是on',
        ];
    }
}
