<?php

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception
{
    protected array $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'code' => 422,
            'msg' => '请求参数错误',
            'errors' => $this->errors
        ], 200);
    }
}
