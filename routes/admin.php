<?php

use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\CleanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SiteKeywordsController;
use App\Http\Controllers\Admin\SiteManagerController;
use App\Http\Controllers\Admin\SoftwareManagementController;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Route;

Route::get('login', [AdminLoginController::class, 'viewLogin'])->name('login.view');
Route::post('admin-login', [AdminLoginController::class, 'login'])->name('login');
Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');

Route::prefix('passwords')->group(function () {
    Route::get('forget-password', [ForgotPasswordController::class, 'getEmail'])->name('forget.password');
    Route::post('forget-password', [ForgotPasswordController::class, 'postEmail'])->name('forget.password.store');

    Route::get('reset-password/{token}', [ResetPasswordController::class, 'getPassword'])->name('reset.password');
    Route::post('reset-password', [ResetPasswordController::class, 'updatePassword'])->name('reset.password.store');
});
Route::middleware('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/backup/logs', [DashboardController::class, 'backupLogs'])->name('backup.logs');
    Route::prefix('language')->as('lang.')->group(function () {
        Route::get('/', [SiteKeywordsController::class, 'index'])->name('index');
        Route::post('store', [SiteKeywordsController::class, 'store'])->name('store');
        Route::get('edit/{id}', [SiteKeywordsController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [SiteKeywordsController::class, 'update'])->name('update');
        Route::get('destroy/{id}', [SiteKeywordsController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('settings')->as('setting.')->group(function () {
        Route::get('/field/setting', [SettingsController::class, 'fieldSetting'])->name('fieldSetting');
    });
    // site managers start from here
    Route::group(['prefix' => 'managers', 'as' => 'managers.'], function () {
        Route::get('/', [SiteManagerController::class, 'index'])->name('index');
        Route::get('/update', [SiteManagerController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'software/management', 'as' => 'software.management.'], function () {
        Route::get('/', [SoftwareManagementController::class, 'index'])->name('index');
        Route::post('/store', [SoftwareManagementController::class, 'store'])->name('store');
        Route::get('edit/{id}', [SoftwareManagementController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [SoftwareManagementController::class, 'update'])->name('update');
    });
    Route::get('clean-data', [CleanController::class, 'clean'])->name('clean.data');

    Route::get('update-package/{package}', function ($package) {
        $siteSetting = SiteSetting::first();
        $siteSetting->update(['package' => $package]);
        return response()->json(['success'=> 'Package updated successfully!']);
    })->name('update.package');
});
