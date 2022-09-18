<?php

namespace App\Admin\Requests\Model;

use App\Common\Requests\Request;

class ListRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'per_page' => 'integer'
        ];
    }

    public function messages()
    {
        return [
            'per_page.integer' => 'per_page 必须是整数'
        ];
    }
}
