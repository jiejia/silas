<?php
use Illuminate\Support\Facades\Route;
use App\Admin\Controllers;

Route::prefix('admin')->group(function () {
    // 入口页面
    Route::get('/login', [Controllers\PageController::class, 'login']);
    Route::get('/forget-password', [Controllers\PageController::class, 'forgetPassword']);
    Route::get('/setting', [Controllers\PageController::class, 'setting']);

    // 首页模块
    Route::get('/', [Controllers\HomeController::class, 'dashboard']);

    // 模型管理
    Route::get('/model', [Controllers\ModelController::class, 'index']);
    Route::get('/model/add', [Controllers\ModelController::class, 'add']);
    Route::get('/model/edit/{id}', [Controllers\ModelController::class, 'edit']);

    // 内容管理
    Route::get('/content_{model}', [Controllers\ContentController::class, 'index']);
    Route::get('/content_{model}/add', [Controllers\ContentController::class, 'add']);
    Route::get('/content_{model}/{id}/edit', [Controllers\ContentController::class, 'edit']);

    // 分类管理
    Route::get('/category_{model}', [Controllers\CategoryController::class, 'index']);
    Route::get('/category', [Controllers\CategoryController::class, 'index']);
    Route::get('/category_{model}/add', [Controllers\CategoryController::class, 'add']);
    Route::get('/category/add', [Controllers\CategoryController::class, 'add']);
    Route::get('/category_{model}/{id}/edit', [Controllers\CategoryController::class, 'edit']);
    Route::get('/category/{id}/edit', [Controllers\CategoryController::class, 'edit']);
});
