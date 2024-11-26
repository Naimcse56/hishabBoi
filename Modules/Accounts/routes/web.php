<?php

use Illuminate\Support\Facades\Route;
use Modules\Accounts\App\Http\Controllers\AccountsController;
use Modules\Accounts\App\Http\Controllers\LedgerController;
use Modules\Accounts\App\Http\Controllers\SubLedgerTypeController;

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

Route::group(['prefix' => 'accountings','middleware' => ['auth']], function () {
    Route::resource('accounts', AccountsController::class)->names('accounts');
    Route::controller(LedgerController::class)->group(function () {
        Route::get('/ledger/index', 'index')->name('ledger.index');
        Route::get('/ledger/create', 'create')->name('ledger.create');
        Route::post('/ledger/store', 'store')->name('ledger.store');
        Route::get('/ledger/edit/{id}', 'edit')->name('ledger.edit');
        Route::get('/ledger/show/{id}', 'show')->name('ledger.show');
        Route::post('/ledger/update/{id}', 'update')->name('ledger.update');
        Route::post('/delete', 'destroy')->name('ledger.delete');
        Route::get('/ledger/transactional-account-list-ajax', 'transactional_list_for_select_ajax')->name('ledger.transactional_list_for_select');
        Route::get('/ledger-list', 'list')->name('leadger.list_all');
        Route::post('/ledger/code-checker', 'code_checker')->name('ledger.code_checker');
    });
    Route::controller(SubLedgerTypeController::class)->prefix('/type-wise-party-account')->group(function () {
        Route::get('/index', 'index')->name('subledger-type.index');
        Route::post('/store', 'store')->name('subledger-type.store');
        Route::get('/edit/{id}', 'edit')->name('subledger-type.edit');
        Route::post('/update/{id}', 'update')->name('subledger-type.update');
        Route::post('/delete', 'destroy')->name('subledger-type.delete');
        Route::get('/select-list-ajax', 'list_for_select_ajax')->name('subledger-type.transactional_list_for_select');
        Route::get('/report', 'index_report')->name('subledger-type.index_report');
        Route::get('/report-preview', 'index_report_preview')->name('subledger-type.index_report_preview');
    });
});
