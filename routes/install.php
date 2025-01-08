<?php
/*
|--------------------------------------------------------------------------
| Install Routes
|--------------------------------------------------------------------------
|
| This route is responsible for handling the intallation process
|
|
|
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallController;

Route::controller(InstallController::class)->group(function () {
    Route::get('/', 'step0');
    Route::get('/step1', 'step1')->name('step1');
    Route::get('/step2', 'step2')->name('step2');
    Route::get('/step3/{error?}', 'step3')->name('step3');
    Route::get('/step5', 'step5')->name('step5');

    Route::post('/database_installation', 'database_installation')->name('install.db');
    Route::post('system_settings', 'system_settings')->name('system_settings');
    Route::post('purchase_code', 'purchase_code')->name('purchase.code');
});

