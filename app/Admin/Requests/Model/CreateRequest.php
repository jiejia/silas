<?php

namespace App\Admin\Requests\Model;

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
            'name' => [
                'required',
                'between:2,50',
                Rule::unique('sila_models')->where(function ($query) {
                    return $query->where('deleted_at', null);
                })
            ],
            'table_name' => [
                'required',
                'between:2,50',
                Rule::unique('sila_models')->where(function ($query) {
                    return $query->where('deleted_at', null);
                })
            ],
            'description' => ['max:255'],
            'status' => ['in:on'],
            'open_category' => ['in:on'],
            'fields' => [
                'required', 'array',
            ],

            // 字段公共验证
            'fields.*.form_control' => [
                'required', 'in:text,textarea,editor,select,datetime,numeric,switch,slide,city,color,file',
            ],
            'fields.*.name' => [
                'required', 'between:2,50', 'distinct:strict',
            ],
            'fields.*.table_field_name' => [
                'required', 'between:2,50', 'distinct:strict',
            ],
            'fields.*.comments' => [
                'max:255',
            ],
            'fields.*.is_null' => [
                'required', 'in:1,0',
            ],

            // 文本行 form_control=text
            'fields.*.length' => [
                'required_if:fields.*.form_control,text,textarea', 'integer',
            ],
            'fields.*.valid_rule' => [
                'max:100',
            ],
            'fields.*.valid_msg' => [
                'max:100',
            ],

            // 文本框 form_control=textarea
            'fields.*.config.rows' => [
                'required_if:fields.*.form_control,textarea', 'integer',
            ],
            'fields.*.config.cols' => [
                'required_if:fields.*.form_control,textarea', 'integer',
            ],

            // 下拉框 form_control=select
            'fields.*.config.select_type' => [
                'required_if:fields.*.form_control,select', 'in:single,multiple',
            ],
            'fields.*.config.select_source' => [
                'required_if:fields.*.form_control,select', 'in:source,url',
            ],
            'fields.*.config.select_options' => [
                'required_if:fields.*.form_control,select',
            ],

            // 日期时间 form_control=datetime
            'fields.*.config.date_format' => [
                'required_if:fields.*.form_control,datetime',
            ],
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
            'fields.required' => '至少添加一个字段',
            'fields.array' => '字段应该是数组',
            'fields.*.form_control.required' => '字段类型必选',
            'fields.*.form_control.in' => '字段类型必须是(text,textarea,editor,select,datetime,numeric,switch,slide,city,color,file)其中之一',
            'fields.*.name.required' => '字段名必填',
            'fields.*.name.in' => '字段名应该是2到50个字符',
            'fields.*.name.distinct' => '字段名重复',
            'fields.*.table_field_name.required' => '数据表字段名必填',
            'fields.*.table_field_name.in' => '数据表字段名必填是2到50个英文字符',
            'fields.*.table_field_name.distinct' => '数据表字段名名重复',
            'fields.*.comments.max' => '字段描述最多255个字符',
            'fields.*.is_null.required' => '是否可为空必填',
            'fields.*.is_null.in' => '是否可为空必须是1或0',

            'fields.*.length.required_if' => '长度必填',
            'fields.*.length.integer' => '长度应该为整数',
            'fields.*.valid_rule.max' => '验证规则最长为100个字符',
            'fields.*.valid_msg.max' => '验证提示最长为100个字符',

            'fields.*.config.rows.required_if' => '行必填',
            'fields.*.config.rows.integer' => '行必须为整数',
            'fields.*.config.cols.required_if' => '列必填',
            'fields.*.config.cols.integer' => '列必须为整数',

            'fields.*.config.select_type.required_if' => '类型必填',
            'fields.*.config.select_type.in' => '类型必须是 single,multiple',
            'fields.*.config.select_source.required_if' => '请选择选项来源',
            'fields.*.config.select_source.in' => '选项来源必须是 source,url',
            'fields.*.config.select_options.required_if' => '选项值/描述 必填',

            'fields.*.config.date_format.required_if' => '日期格式必填',
        ];
    }
}
