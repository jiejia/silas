<?php

namespace App\Admin\Requests\Category;

use App\Common\Requests\Request;
use Illuminate\Validation\Rule;

class CreateRequest extends Request
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
            'model_id' => ['required',
                Rule::exists('sila_models', 'id')->where(function ($query) {
                    return $query->where('deleted_at', null);
                })
            ],
            'parent_id' => ['required',
                Rule::exists('sila_categories', 'id')->where(function ($query) {
                    return $query->where('deleted_at', null);
                })
            ],
            'name' => [
                'required',
                'between:2,50',
                Rule::unique('sila_categories')->where(function ($query) {
                    return $query->where('deleted_at', null)->where('model_id', $this->model_id);
                })
            ],
            'slug' => [
                'required',
                'between:2,50',
                Rule::unique('sila_categories')->where(function ($query) {
                    return $query->where('deleted_at', null)->where('model_id', $this->model_id);
                })
            ],
            'cover' => ['integer'],
            'status' => ['in:on'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名称不能为空',
            'name.between' => '名称应在2至50个字符',
            'name.unique' => '名称已存在',
            'slug.required' => 'slug 不能为空',
            'slug.between' => 'slug 应在2至50个字符',
            'slug.unique' => 'slug 已存在',
            'model_id.required' => 'model_id 不能为空',
            'model_id.exists' => '模型不存在',
            'parent_id.required' => '父分类不能为空',
            'parent_id.exists' => '父分类不存在',
            'status.in' => '状态只能是on',
        ];
    }
}
