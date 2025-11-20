<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\AuthController;
use Modules\User\Http\Controllers\OverviewController;
use Modules\User\Http\Controllers\UserController;
use Modules\User\Http\Middleware\AuthenticateUser;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('user.')->prefix('user')->middleware([AuthenticateUser::class])->group(function () {
    // Hiển thị form login & register (GET)
    Route::get('login', [AuthController::class, 'login'])->name('login')->withoutMiddleware(AuthenticateUser::class);
    Route::get('register', [AuthController::class, 'register'])->name('register')->withoutMiddleware(AuthenticateUser::class);

    // Xử lý đăng nhập & đăng ký (POST)
    Route::post('login', [AuthController::class, 'handleLogin'])->name('login.submit')->withoutMiddleware(AuthenticateUser::class);
    Route::post('register', [AuthController::class, 'handleRegister'])->name('register.submit')->withoutMiddleware(AuthenticateUser::class);

    // Đăng xuất
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('overview', [OverviewController::class, 'index'])->name('overview');
    Route::resource('profile', UserController::class);
});
