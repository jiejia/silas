<?php
use Illuminate\Support\Facades\Route;
use App\Admin\Controllers\Api;

Route::group(['middleware' => 'auth:api', 'prefix' => 'admin'], function ($router) {
    // 权限相关
    Route::post('/auth/logout', [Api\AuthController::class, 'logout']);
    Route::post('/auth/refresh', [Api\AuthController::class, 'refresh']);
    Route::post('/auth/me', [Api\AuthController::class, 'me']);

    // 模型管理
    Route::post('/model/create', [Api\ModelController::class, 'create']);
    Route::post('/model/update/{id}', [Api\ModelController::class, 'update']);
    Route::post('/model/list', [Api\ModelController::class, 'list']);
    Route::post('/model/{id}', [Api\ModelController::class, 'detail'])->where('id', '[0-9]+');;
    Route::post('/model/delete', [Api\ModelController::class, 'delete']);

    // 内容管理
    Route::post('/content_{model}/create', [Api\ContentController::class, 'create']);
    Route::post('/content_{model}/update/{id}', [Api\ContentController::class, 'update']);
    Route::post('/content/nav', [Api\ContentController::class, 'nav']);
    Route::post('/content_{model}/list/', [Api\ContentController::class, 'list']);
    Route::post('/content_{model}/detail/{id}', [Api\ContentController::class, 'detail'])->where('id', '[0-9]+');;
    Route::post('/content_{model}/delete', [Api\ContentController::class, 'delete']);
});

Route::group(['prefix' => 'admin'], function ($route) {
    Route::post('/auth/login', [Api\AuthController::class, 'login']);
});
