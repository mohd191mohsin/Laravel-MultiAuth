<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserMiddleware;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\Admin\AdminMiddleware;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminLoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name("admin.")->group(function () {
    Route::middleware(GuestMiddleware::class)->group(function () {
        Route::get("/login",[AdminLoginController::class, "index"]);
        Route::post("/login",[AdminLoginController::class, "login"])->name("login");
    });

    Route::middleware(['auth',AdminMiddleware::class])->group(function () {
        Route::get("/home",[AdminHomeController::class, 'index'])->name('home');
    });
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(UserMiddleware::class);
