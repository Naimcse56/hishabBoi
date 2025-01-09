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

Route::group(['prefix' => 'system','middleware' => ['auth','isActiveUser']], function () {
    Route::controller(BaseController::class)->prefix('base-configurations')->group(function () {
        Route::get('/user-permisssions', 'user_permisssions')->name('user.permisssions')->middleware(['permission:staff_permission']);
        Route::post('/store-permisssions', 'store_permisssions')->name('store.permisssions')->middleware(['permission:staff_permission']);
        Route::get('/general-settings', 'general_settings')->name('general_settings.configurations')->middleware(['permission:general_settings']);
        Route::get('/company-settings', 'company_settings')->name('company_settings.configurations')->middleware(['permission:company_settings']);
        Route::post('/base-settings-update', 'base_settings_update')->name('base_settings_update.configurations')->middleware(['permission:general_settings']);
        Route::get('/email-settings', 'email_settings')->name('email_settings.configurations')->middleware(['permission:email_settings']);
        Route::post('/settings-update', 'env_settings_update')->name('env_settings_update')->middleware(['permission:email_settings']);
        Route::post('/test-mail-send', 'test_mail_send')->name('test_mail_send')->middleware(['permission:email_settings']);
        Route::get('/sales-purchase-configuration', 'sales_purchase')->name('sales_purchase.configurations')->middleware(['permission:sales_purchase_settings']);
    });
    Route::controller(CurrencyController::class)->prefix('currencies')->group(function () {
        Route::get('/index', 'index')->name('currencies.index')->middleware(['permission:view_currency']); 
        Route::get('/create', 'create')->name('currencies.create')->middleware(['permission:create_currency']);
        Route::post('/store', 'store')->name('currencies.store')->middleware(['permission:create_currency']);
        Route::get('/edit/{id}', 'edit')->name('currencies.edit')->middleware(['permission:edit_currency']);
        Route::get('/show/{id}', 'show')->name('currencies.show')->middleware(['permission:view_currency']);
        Route::post('/update/{id}', 'update')->name('currencies.update')->middleware(['permission:edit_currency']);
        Route::post('/delete', 'destroy')->name('currencies.delete')->middleware(['permission:delete_currency']);
        Route::get('/list-ajax', 'list_for_select')->name('currencies.list_for_select');
    });
    Route::controller(LanguageController::class)->prefix('language')->group(function () {
        Route::get('/index', 'index')->name('language.index')->middleware(['permission:view_language']);
        Route::post('/store', 'store')->name('language.store')->middleware(['permission:create_language']);
        Route::get('/edit/{id}', 'edit')->name('language.edit')->middleware(['permission:edit_language']);
        Route::get('/transaltion-view/{id}', 'translate_view')->name('language.translate_view')->middleware(['permission:view_language']);
        Route::get('/show/{id}', 'show')->name('language.show')->middleware(['permission:view_language']);
        Route::post('/update/{id}', 'update')->name('language.update')->middleware(['permission:edit_language']);
        Route::post('/delete', 'destroy')->name('language.delete')->middleware(['permission:delete_language']);
        Route::get('/list-ajax', 'list_for_select')->name('language.list_for_select');
        Route::get('/get-translate-file/{file_name}/{language_id}', 'get_translate_file')->name('language.get_translate_file');
        Route::post('/key-value-store', 'key_value_store')->name('language.key_value_store')->middleware(['permission:view_language']);
    });
});
Route::group(['prefix' => 'human-resource','middleware' => ['auth','isActiveUser']], function () {
    Route::controller(DesignationController::class)->prefix('designation')->group(function () {
        Route::get('/index', 'index')->name('designation.index')->middleware(['permission:view_designation']);
        Route::post('/store', 'store')->name('designation.store')->middleware(['permission:create_designation']);
        Route::get('/edit/{id}', 'edit')->name('designation.edit')->middleware(['permission:edit_designation']);
        Route::get('/show/{id}', 'show')->name('designation.show')->middleware(['permission:view_designation']);
        Route::post('/update/{id}', 'update')->name('designation.update')->middleware(['permission:edit_designation']);
        Route::post('/delete', 'destroy')->name('designation.delete')->middleware(['permission:delete_designation']);
        Route::get('/list-ajax', 'list_for_select')->name('designation.list_for_select');
    });
    Route::controller(DepartmentController::class)->prefix('departments')->group(function () {
        Route::get('/index', 'index')->name('departments.index')->middleware(['permission:view_department']);
        Route::post('/store', 'store')->name('departments.store')->middleware(['permission:create_department']);
        Route::get('/edit/{id}', 'edit')->name('departments.edit')->middleware(['permission:edit_department']);
        Route::get('/show/{id}', 'show')->name('departments.show')->middleware(['permission:view_department']);
        Route::post('/update/{id}', 'update')->name('departments.update')->middleware(['permission:edit_department']);
        Route::post('/delete', 'destroy')->name('departments.delete')->middleware(['permission:delete_department']);
        Route::get('/list-ajax', 'list_for_select')->name('departments.list_for_select');
    });
    Route::controller(StaffController::class)->prefix('staffs')->group(function () {
        Route::get('/index', 'index')->name('staffs.index')->middleware(['permission:view_users']);
        Route::get('/create', 'create')->name('staffs.create')->middleware(['permission:create_users']);
        Route::post('/store', 'store')->name('staffs.store')->middleware(['permission:create_users']);
        Route::get('/edit/{id}', 'edit')->name('staffs.edit')->middleware(['permission:edit_users']);
        Route::get('/show/{id}', 'show')->name('staffs.show')->middleware(['permission:view_users']);
        Route::post('/update/{id}', 'update')->name('staffs.update')->middleware(['permission:edit_users']);
        Route::post('/delete', 'destroy')->name('staffs.delete')->middleware(['permission:delete_users']);
        Route::get('/list-ajax', 'list_for_select')->name('staffs.list_for_select');
    });
});
