<?php

use Illuminate\Support\Facades\Route;
use Modules\Base\App\Http\Controllers\BaseController;
use Modules\Base\App\Http\Controllers\CurrencyController;

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

Route::group(['prefix' => 'system','middleware' => ['auth']], function () {
    Route::controller(BaseController::class)->prefix('base-configurations')->group(function () {
        Route::get('/company-settings', 'company_settings')->name('company_settings.configurations');
        Route::post('/base-settings-update', 'base_settings_update')->name('base_settings_update.configurations');
        Route::get('/email-settings', 'email_settings')->name('email_settings.configurations');
        Route::post('/settings-update', 'env_settings_update')->name('env_settings_update');
        Route::post('/test-mail-send', 'test_mail_send')->name('test_mail_send');
        Route::get('/terms-condition', 'terms_condition')->name('terms_condition.configurations');
    });
    Route::controller(CurrencyController::class)->prefix('currencies')->group(function () {
        Route::get('/index', 'index')->name('currencies.index');
        Route::get('/create', 'create')->name('currencies.create');
        Route::post('/store', 'store')->name('currencies.store');
        Route::get('/edit/{id}', 'edit')->name('currencies.edit');
        Route::get('/show/{id}', 'show')->name('currencies.show');
        Route::post('/update/{id}', 'update')->name('currencies.update');
        Route::post('/delete', 'destroy')->name('currencies.delete');
        Route::get('/list-ajax', 'list_for_select')->name('currencies.list_for_select');
    });
});
