<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\servers\DashboardController;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'auth_login']);

Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'auth_register']);

Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/auth/redirect', [SocialiteController::class, 'redirect'])->name('auth.socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('auth.socialite.callback');

Route::group(['middleware' => ['auth', 'useradmin']], function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('category', App\Http\Controllers\servers\CategoryController::class);
        Route::resource('role', App\Http\Controllers\servers\RoleController::class);
        Route::resource('user', App\Http\Controllers\servers\UserController::class);
});
