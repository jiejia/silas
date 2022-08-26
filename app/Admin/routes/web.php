<?php
use Illuminate\Support\Facades\Route;
use App\Admin\Controllers;

Route::prefix('admin')->group(function () {
    Route::get('/login', [Controllers\PageController::class, 'login']);
    Route::get('/', [Controllers\PageController::class, 'dashboard']);
    Route::get('/forget-password', [Controllers\PageController::class, 'forgetPassword']);
    Route::get('/setting', [Controllers\PageController::class, 'setting']);
});
