<?php

use Illuminate\Support\Facades\Route;
use Modules\Accounts\App\Http\Controllers\AccountsController;
use Modules\Accounts\App\Http\Controllers\LedgerController;
use Modules\Accounts\App\Http\Controllers\SubLedgerTypeController;
use Modules\Accounts\App\Http\Controllers\WorkOrderController;
use Modules\Accounts\App\Http\Controllers\WorkOrderSiteController;
use Modules\Accounts\App\Http\Controllers\CashPaymentJournalController;
use Modules\Accounts\App\Http\Controllers\BankPaymentJournalController;
use Modules\Accounts\App\Http\Controllers\CashReceiveJournalController;
use Modules\Accounts\App\Http\Controllers\BankReceiveJournalController;
use Modules\Accounts\App\Http\Controllers\JournalController;
use Modules\Accounts\App\Http\Controllers\OpeningBalanceController;
use Modules\Accounts\App\Http\Controllers\AccountsPeriodController;
use Modules\Accounts\App\Http\Controllers\JournalWorkOrderController;

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
    });
    Route::controller(SubLedgerController::class)->prefix('/party-accounts')->group(function () {
        Route::get('/supplier-index', 'index')->name('sub-ledger.index');
        Route::get('/create', 'create')->name('sub-ledger.create');
        Route::post('/store', 'store')->name('sub-ledger.store');
        Route::get('/edit/{id}', 'edit')->name('sub-ledger.edit');
        Route::get('/show/{id}', 'show')->name('sub-ledger.show');
        Route::post('/update/{id}', 'update')->name('sub-ledger.update');
        Route::post('/delete', 'destroy')->name('sub-ledger.delete');
        Route::get('/transactional-account-list-ajax', 'transactional_list_for_select_ajax')->name('sub-ledger.transactional_list_for_select');
    });
    Route::controller(WorkOrderController::class)->prefix('/work-order')->group(function () {
        Route::get('/index', 'index')->name('work-order.index');
        Route::get('/create', 'create')->name('work-order.create');
        Route::post('/store', 'store')->name('work-order.store');
        Route::get('/edit/{id}', 'edit')->name('work-order.edit');
        Route::get('/show/{id}', 'show')->name('work-order.show');
        Route::post('/update/{id}', 'update')->name('work-order.update');
        Route::post('/delete', 'destroy')->name('work-order.delete');
        Route::get('/work-order-list-ajax', 'list_for_select_ajax')->name('work-order.list_for_select');
        Route::get('/work-order-estimation-cost-row', 'get_row')->name('work-order.get_row');
        Route::get('/work-order-profit-loss-report', 'profit_loss_report')->name('work-orders.pl_report');
        Route::get('/work-order-balance-sheet-report', 'balance_sheet_report')->name('work-orders.balance_sheet_report');
        Route::get('/receive-payment-report', 'receive_payment_report')->name('work-orders.receive_payment_report');
    });
    Route::controller(WorkOrderSiteController::class)->prefix('/work-order-sites')->group(function () {
        Route::get('/index', 'index')->name('work-order-sites.index');
        Route::get('/create', 'create')->name('work-order-sites.create');
        Route::post('/store', 'store')->name('work-order-sites.store');
        Route::get('/edit/{id}', 'edit')->name('work-order-sites.edit');
        Route::get('/show/{id}', 'show')->name('work-order-sites.show');
        Route::post('/update/{id}', 'update')->name('work-order-sites.update');
        Route::post('/delete', 'destroy')->name('work-order-sites.delete');
        Route::get('/work-order-list-ajax', 'list_for_select_ajax')->name('work-order-sites.list_for_select');
    });
    Route::controller(CashPaymentJournalController::class)->prefix('/cash-payment-journal')->group(function () {
        Route::get('/index', 'index')->name('multi-cash-payment.index');
        Route::get('/create', 'create')->name('multi-cash-payment.create');
        Route::post('/store', 'store')->name('multi-cash-payment.store');
        Route::get('/edit/{id}', 'edit')->name('multi-cash-payment.edit');
        Route::get('/show/{id}', 'show')->name('multi-cash-payment.show');
        Route::post('/update/{id}', 'update')->name('multi-cash-payment.update');
        Route::post('/delete', 'destroy')->name('multi-cash-payment.delete');
        Route::get('/add-new-row-cr-entry', 'add_new_line_cr')->name('multi-cash-payment.add_new_line_cr');
        Route::get('/print/{id}', 'print')->name('multi-cash-payment.print');
    });
    Route::controller(BankPaymentJournalController::class)->prefix('/bank-payment-journal')->group(function () {
        Route::get('/index', 'index')->name('multi-bank-payment.index');
        Route::get('/create', 'create')->name('multi-bank-payment.create');
        Route::post('/store', 'store')->name('multi-bank-payment.store');
        Route::get('/edit/{id}', 'edit')->name('multi-bank-payment.edit');
        Route::get('/show/{id}', 'show')->name('multi-bank-payment.show');
        Route::post('/update/{id}', 'update')->name('multi-bank-payment.update');
        Route::post('/delete', 'destroy')->name('multi-bank-payment.delete');
        Route::get('/add-new-row-cr-entry', 'add_new_line_cr')->name('multi-bank-payment.add_new_line_cr');
        Route::get('/print/{id}', 'print')->name('multi-bank-payment.print');
    });
    Route::controller(CashReceiveJournalController::class)->prefix('/cash-receive-journal')->group(function () {
        Route::get('/index', 'index')->name('multi-cash-receive.index');
        Route::get('/create', 'create')->name('multi-cash-receive.create');
        Route::post('/store', 'store')->name('multi-cash-receive.store');
        Route::get('/edit/{id}', 'edit')->name('multi-cash-receive.edit');
        Route::get('/show/{id}', 'show')->name('multi-cash-receive.show');
        Route::post('/update/{id}', 'update')->name('multi-cash-receive.update');
        Route::post('/delete', 'destroy')->name('multi-cash-receive.delete');
        Route::get('/add-new-row-cr-entry', 'add_new_line_cr')->name('multi-cash-receive.add_new_line_cr');
        Route::get('/print/{id}', 'print')->name('multi-cash-receive.print');
    });
    Route::controller(BankReceiveJournalController::class)->prefix('/bank-receive-journal')->group(function () {
        Route::get('/index', 'index')->name('multi-bank-receive.index');
        Route::get('/create', 'create')->name('multi-bank-receive.create');
        Route::post('/store', 'store')->name('multi-bank-receive.store');
        Route::get('/edit/{id}', 'edit')->name('multi-bank-receive.edit');
        Route::get('/show/{id}', 'show')->name('multi-bank-receive.show');
        Route::post('/update/{id}', 'update')->name('multi-bank-receive.update');
        Route::post('/delete', 'destroy')->name('multi-bank-receive.delete');
        Route::get('/add-new-row-cr-entry', 'add_new_line_cr')->name('multi-bank-receive.add_new_line_cr');
        Route::get('/print/{id}', 'print')->name('multi-bank-receive.print');
    });
    Route::controller(JournalController::class)->prefix('/general-journal')->group(function () {
        Route::get('/index', 'index')->name('journal.index');
        Route::get('/create', 'create')->name('journal.create');
        Route::post('/store', 'store')->name('journal.store');
        Route::get('/edit/{id}', 'edit')->name('journal.edit');
        Route::get('/show/{id}', 'show')->name('journal.show');
        Route::post('/update/{id}', 'update')->name('journal.update');
        Route::post('/delete', 'destroy')->name('journal.delete');
        Route::get('/add-new-row-entry', 'add_new_line')->name('journal.add_new_line');
        Route::get('/print/{id}', 'print')->name('journal.print');
    });
    Route::controller(OpeningBalanceController::class)->prefix('/opening-balance')->group(function () {
        Route::get('/index', 'index')->name('opening-balance.index');
        Route::get('/create', 'create')->name('opening-balance.create');
        Route::post('/store', 'store')->name('opening-balance.store');
        Route::get('/edit/{id}', 'edit')->name('opening-balance.edit');
        Route::get('/show/{id}', 'show')->name('opening-balance.show');
        Route::post('/update/{id}', 'update')->name('opening-balance.update');
        Route::post('/delete', 'destroy')->name('opening-balance.delete');
        Route::get('/print/{id}', 'print')->name('opening-balance.print');
    });
    Route::controller(AccountsController::class)->prefix('configuration')->group(function () {
        Route::get('/report', 'report_config')->name('accountings.report-config');
        Route::post('/general-store', 'general_config_store')->name('accountings.general-config-store');
    });
    Route::controller(AccountsPeriodController::class)->group(function () {
        Route::get('/day-closing', 'day_closing_list')->name('accountings.day_closing_list');
        Route::get('/day-closing-current-date', 'day_closing_current_date')->name('accountings.day_closing_current_date');
        Route::post('/day-closing-now', 'day_closing_confirm')->name('accountings.day_closing_confirm');
        Route::get('/day-closing-check/{id}', 'day_closing_check')->name('accountings.day_closing_check');
    });
    Route::controller(JournalWorkOrderController::class)->prefix('/journal/work-order-based')->group(function () {
        Route::get('/index', 'index')->name('journal.work_order.index');
        Route::get('/create', 'create')->name('journal.work_order.create');
        Route::post('/store', 'store')->name('journal.work_order.store');
        Route::get('/edit/{id}', 'edit')->name('journal.work_order.edit');
        Route::get('/show/{id}', 'show')->name('journal.work_order.show');
        Route::post('/update/{id}', 'update')->name('journal.work_order.update');
        Route::post('/delete', 'destroy')->name('journal.work_order.delete');
        Route::get('/print/{id}', 'print')->name('journal.work_order.print');
    });
    Route::controller(VouchersController::class)->prefix('/voucher-approval')->group(function () {
        Route::get('/index', 'approval_index')->name('voucher.approval_index');
        Route::get('/show/{id}', 'show')->name('voucher.show');
        Route::post('/delete', 'destroy')->name('voucher.delete');
        Route::post('/approve-now', 'approve_now')->name('voucher.approve_now');
        Route::post('/multiple-approve-now', 'multiple_approve_now')->name('voucher.multiple_approve_now');
        Route::get('/accountant', 'rejected_by_accountant_index')->name('reject_by_accountant.index');
    });
    Route::controller(AccountsController::class)->prefix('/reports')->group(function () {
        Route::get('/cashbook', 'cashbook')->name('accountings.cashbook');
        Route::get('/bankbook', 'bankbook')->name('accountings.bankbook');
        Route::get('/ledger-report', 'ledger_report')->name('accountings.ledger_report');
        Route::get('/party-accounts-report', 'sub_ledger_report')->name('accountings.sub_ledger_report');
        Route::get('/party-accounts-summary-report', 'sub_ledger_summary_report')->name('accountings.sub_ledger_summary_report');
        Route::get('/work-order-report', 'work_order_report')->name('accountings.work_order_report');
    });
});
