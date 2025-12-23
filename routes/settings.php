<?php

use App\Http\Controllers\User\SettingsController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::prefix('settings')->group(function () {
        Route::get('language', [SettingsController::class, 'language'])->name('language');
        Route::get('menu-size', [SettingsController::class, 'menuSizes'])->name('menu.size');
        Route::get('page-length', [SettingsController::class, 'pageLength'])->name('page.length');
    });
});
