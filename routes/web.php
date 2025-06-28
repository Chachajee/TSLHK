<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminDashboardController;

// Main Page Route

Route::middleware(['admin.auth'])->group(function () {
    Route::get('/admin/dashboard', [HomePage::class, 'index'])->name('pages-home');
    Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

    // locale
    Route::get('/lang/{locale}', [LanguageController::class, 'swap']);
    Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
    Route::post('/auth/login-basic', [LoginBasic::class, 'login'])->name('auth-login-basic.submit');
    Route::post('/auth/logout-basic', [LoginBasic::class, 'logout'])->name('auth-logout-basic');
    Route::get('/admin/login', [LoginBasic::class, 'index'])->name('auth-login-basic');
});

Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');