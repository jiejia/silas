<?php

namespace App\Admin\Requests;

use App\Common\Requests\Request;

class LoginRequest extends Request
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
            'email' => ['required', 'email'],
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'email 不能为空',
            'email.email' => 'email 格式错误',
            'password.required' => '密码不能为空'
        ];
    }
}
