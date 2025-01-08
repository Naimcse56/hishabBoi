<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallController;

Auth::routes();

Route::group(['middleware' => ['auth','isActiveUser']], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile_edit'])->name('profile_edit');
    Route::post('/profile-update', [App\Http\Controllers\HomeController::class, 'profile_update'])->name('profile_update');
});
Route::controller(InstallController::class)->group(function () {
    Route::get('/database-migrate', 'database_installation')->middleware(['checkInstalled']);
});