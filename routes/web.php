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
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\CreditNoteController;
use App\Http\Controllers\RMAFormController;
use App\Http\Controllers\DashboardController;

// Main Page Route
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['admin.auth'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

    // locale
    Route::get('/lang/{locale}', [LanguageController::class, 'swap']);
    Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
    Route::post('/auth/login-basic', [LoginBasic::class, 'login'])->name('auth-login-basic.submit');
    Route::post('/auth/logout-basic', [LoginBasic::class, 'logout'])->name('auth-logout-basic');
    Route::get('/admin/login', [LoginBasic::class, 'index'])->name('auth-login-basic');

    // Invoice routes
    Route::resource('admin/invoices', InvoiceController::class)->names([
        'index' => 'admin.invoices.index',
        'create' => 'admin.invoices.create',
        'store' => 'admin.invoices.store',
        'show' => 'admin.invoices.show',
        'edit' => 'admin.invoices.edit',
        'update' => 'admin.invoices.update',
        'destroy' => 'admin.invoices.destroy',
    ]);

    // Invoice download route
    Route::get('/admin/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('admin.invoices.download');

    // Salary routes
    Route::resource('admin/salaries', SalaryController::class)->names([
        'index' => 'admin.salaries.index',
        'create' => 'admin.salaries.create',
        'store' => 'admin.salaries.store',
        'show' => 'admin.salaries.show',
        'edit' => 'admin.salaries.edit',
        'update' => 'admin.salaries.update',
        'destroy' => 'admin.salaries.destroy',
    ]);

    // Salary download route
    Route::get('/admin/salaries/{salary}/download', [SalaryController::class, 'download'])->name('admin.salaries.download');

    // Credit Note routes
    Route::resource('admin/credit-notes', CreditNoteController::class)->names([
        'index' => 'admin.credit-notes.index',
        'create' => 'admin.credit-notes.create',
        'store' => 'admin.credit-notes.store',
        'show' => 'admin.credit-notes.show',
        'edit' => 'admin.credit-notes.edit',
        'update' => 'admin.credit-notes.update',
        'destroy' => 'admin.credit-notes.destroy',
    ]);

    // Credit Note download route
    Route::get('/admin/credit-notes/{creditNote}/download', [CreditNoteController::class, 'download'])->name('admin.credit-notes.download');

    // RMA Form routes
    Route::get('/rma-form', [RMAFormController::class, 'index'])->name('rma.index');
    Route::get('/rma-form/download', [RMAFormController::class, 'download'])->name('rma.download');
});

Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');