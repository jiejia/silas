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
            'email' => 'required',
            'password' => 'required',
        ];
    }
}
