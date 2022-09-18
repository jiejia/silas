<?php

namespace App\Admin\Requests\Model;

use App\Common\Requests\Request;
use Illuminate\Validation\Rule;

class UpdateRequest extends Request
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
            'name' => ['required', 'between:2,50', Rule::unique('sila_models')->ignore($this->id)],
            'table_name' => ['required', 'between:2,30', Rule::unique('sila_models')->ignore($this->id)],
            'description' => ['max:255'],
            'status' => ['in:on'],
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
