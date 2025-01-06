<?php

use Illuminate\Support\Facades\Route;
use Modules\Base\App\Http\Controllers\BaseController;
use Modules\Base\App\Http\Controllers\CurrencyController;
use Modules\Base\App\Http\Controllers\LanguageController;
use Modules\Base\App\Http\Controllers\DesignationController;
use Modules\Base\App\Http\Controllers\DepartmentController;
use Modules\Base\App\Http\Controllers\StaffController;

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
        Route::get('/user-permisssions', 'user_permisssions')->name('user.permisssions');
        Route::post('/store-permisssions', 'store_permisssions')->name('store.permisssions');
        Route::get('/general-settings', 'general_settings')->name('general_settings.configurations');
        Route::get('/company-settings', 'company_settings')->name('company_settings.configurations');
        Route::post('/base-settings-update', 'base_settings_update')->name('base_settings_update.configurations');
        Route::get('/email-settings', 'email_settings')->name('email_settings.configurations');
        Route::post('/settings-update', 'env_settings_update')->name('env_settings_update');
        Route::post('/test-mail-send', 'test_mail_send')->name('test_mail_send');
        Route::get('/sales-purchase-configuration', 'sales_purchase')->name('sales_purchase.configurations');
    });
    Route::controller(CurrencyController::class)->prefix('currencies')->group(function () {
        Route::get('/index', 'index')->name('currencies.index');
        Route::post('/store', 'store')->name('currencies.store');
        Route::get('/edit/{id}', 'edit')->name('currencies.edit');
        Route::get('/show/{id}', 'show')->name('currencies.show');
        Route::post('/update/{id}', 'update')->name('currencies.update');
        Route::post('/delete', 'destroy')->name('currencies.delete');
        Route::get('/list-ajax', 'list_for_select')->name('currencies.list_for_select');
    });
    Route::controller(LanguageController::class)->prefix('language')->group(function () {
        Route::get('/index', 'index')->name('language.index');
        Route::post('/store', 'store')->name('language.store');
        Route::get('/edit/{id}', 'edit')->name('language.edit');
        Route::get('/transaltion-view/{id}', 'translate_view')->name('language.translate_view');
        Route::get('/show/{id}', 'show')->name('language.show');
        Route::post('/update/{id}', 'update')->name('language.update');
        Route::post('/delete', 'destroy')->name('language.delete');
        Route::get('/list-ajax', 'list_for_select')->name('language.list_for_select');
        Route::get('/get-translate-file/{file_name}/{language_id}', 'get_translate_file')->name('language.get_translate_file');
        Route::post('/key-value-store', 'key_value_store')->name('language.key_value_store');
    });
});
Route::group(['prefix' => 'human-resource','middleware' => ['auth']], function () {
    Route::controller(DesignationController::class)->prefix('designation')->group(function () {
        Route::get('/index', 'index')->name('designation.index');
        Route::post('/store', 'store')->name('designation.store');
        Route::get('/edit/{id}', 'edit')->name('designation.edit');
        Route::get('/show/{id}', 'show')->name('designation.show');
        Route::post('/update/{id}', 'update')->name('designation.update');
        Route::post('/delete', 'destroy')->name('designation.delete');
        Route::get('/list-ajax', 'list_for_select')->name('designation.list_for_select');
    });
    Route::controller(DepartmentController::class)->prefix('departments')->group(function () {
        Route::get('/index', 'index')->name('departments.index');
        Route::post('/store', 'store')->name('departments.store');
        Route::get('/edit/{id}', 'edit')->name('departments.edit');
        Route::get('/show/{id}', 'show')->name('departments.show');
        Route::post('/update/{id}', 'update')->name('departments.update');
        Route::post('/delete', 'destroy')->name('departments.delete');
        Route::get('/list-ajax', 'list_for_select')->name('departments.list_for_select');
    });
    Route::controller(StaffController::class)->prefix('staffs')->group(function () {
        Route::get('/index', 'index')->name('staffs.index');
        Route::view('/create', 'base::staffs.create')->name('staffs.create');
        Route::post('/store', 'store')->name('staffs.store');
        Route::get('/edit/{id}', 'edit')->name('staffs.edit');
        Route::get('/show/{id}', 'show')->name('staffs.show');
        Route::post('/update/{id}', 'update')->name('staffs.update');
        Route::post('/delete', 'destroy')->name('staffs.delete');
        Route::get('/list-ajax', 'list_for_select')->name('staffs.list_for_select');
    });
});
