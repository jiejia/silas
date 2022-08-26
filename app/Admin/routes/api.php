<?php
use Illuminate\Support\Facades\Route;
use App\Admin\Controllers\Api;

Route::group(['middleware' => 'api'], function ($router) {
    // 权限相关
    Route::post('auth/login', [Api\AuthController::class, 'login']);
    Route::post('auth/logout', [Api\AuthController::class, 'logout']);
    Route::post('auth/refresh', [Api\AuthController::class, 'refresh']);
    Route::post('auth/me', [Api\AuthController::class, 'me']);
});
