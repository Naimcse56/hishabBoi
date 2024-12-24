<?php

use Illuminate\Support\Facades\Route;
use Modules\Base\App\Http\Controllers\BaseController;

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

Route::group([], function () {
    Route::controller(BaseController::class)->prefix('base-configurations')->group(function () {
        Route::get('/company-settings', 'company_settings')->name('company_settings.configurations');
        Route::post('/company-settings-update', 'company_settings_update')->name('company_settings_update.configurations');
    });
});
