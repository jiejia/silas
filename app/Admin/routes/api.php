<?php
use Illuminate\Support\Facades\Route;
use App\Admin\Controllers\Api;

Route::group(['middleware' => 'auth:api', 'prefix' => 'admin'], function ($router) {
    // 权限相关
    Route::post('/auth/logout', [Api\AuthController::class, 'logout']);
    Route::post('/auth/refresh', [Api\AuthController::class, 'refresh']);
    Route::post('/auth/me', [Api\AuthController::class, 'me']);

    // 模型
    Route::post('/model/create', [Api\ModelController::class, 'create']);
    Route::post('/model/update/{id}', [Api\ModelController::class, 'update']);
    Route::post('/model/list', [Api\ModelController::class, 'list']);
    Route::post('/model/{id}', [Api\ModelController::class, 'detail']);
});

Route::group(['prefix' => 'admin'], function ($route) {
    Route::post('/auth/login', [Api\AuthController::class, 'login']);
});
