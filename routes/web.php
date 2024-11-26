<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile_edit'])->name('profile_edit');
Route::post('/profile-update', [App\Http\Controllers\HomeController::class, 'profile_update'])->name('profile_update');
Route::get('/post-select', [App\Http\Controllers\PostController::class, 'post_select'])->name('post-select');
Route::get('/trigger-500', function () {
    abort(500);
});
