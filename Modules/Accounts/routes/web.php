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
use Modules\Accounts\App\Http\Controllers\BalanceSheetController;
use Modules\Accounts\App\Http\Controllers\IncomeStatementController;
use Modules\Accounts\App\Http\Controllers\TrialBalanceController;
use Modules\Accounts\App\Http\Controllers\ProductController;
use Modules\Accounts\App\Http\Controllers\ProductUnitController;
use Modules\Accounts\App\Http\Controllers\SaleController;
use Modules\Accounts\App\Http\Controllers\QuotationController;
use Modules\Accounts\App\Http\Controllers\PurchaseController;
use Modules\Accounts\App\Http\Controllers\LedgerDetailsReportController;

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
  

Route::group(['prefix' => 'accountings','middleware' => ['auth','isActiveUser']], function () {
    Route::controller(LedgerController::class)->group(function () {
        Route::get('/ledger/index', 'index')->name('ledger.index')->middleware(['permission:view_ledger']);
        Route::get('/ledger/create', 'create')->name('ledger.create')->middleware(['permission:create_ledger']);
        Route::post('/ledger/store', 'store')->name('ledger.store')->middleware(['permission:create_ledger']);
        Route::get('/ledger/edit/{id}', 'edit')->name('ledger.edit')->middleware(['permission:edit_ledger']);
        Route::get('/ledger/show/{id}', 'show')->name('ledger.show')->middleware(['permission:view_ledger']);
        Route::post('/ledger/update/{id}', 'update')->name('ledger.update')->middleware(['permission:edit_ledger']);
        Route::post('/ledger/delete', 'destroy')->name('ledger.delete')->middleware(['permission:delete_ledger']);
        Route::get('/ledger/transactional-account-list-ajax', 'transactional_list_for_select_ajax')->name('ledger.transactional_list_for_select');
        Route::post('/ledger/code-checker', 'code_checker')->name('ledger.code_checker');
    });
    Route::controller(SubLedgerTypeController::class)->prefix('/type-wise-party-account')->group(function () {
        Route::get('/index', 'index')->name('subledger-type.index')->middleware(['permission:view_party_type']);
        Route::post('/store', 'store')->name('subledger-type.store')->middleware(['permission:create_party_type']);
        Route::get('/edit/{id}', 'edit')->name('subledger-type.edit')->middleware(['permission:edit_party_type']);
        Route::post('/update/{id}', 'update')->name('subledger-type.update')->middleware(['permission:edit_party_type']);
        Route::post('/delete', 'destroy')->name('subledger-type.delete')->middleware(['permission:delete_party_type']);
        Route::get('/select-list-ajax', 'list_for_select_ajax')->name('subledger-type.transactional_list_for_select');
    });
    Route::controller(SubLedgerController::class)->prefix('/party-accounts')->group(function () {
        Route::get('/supplier-index', 'index')->name('sub-ledger.index')->middleware(['permission:view_party']);
        Route::get('/create', 'create')->name('sub-ledger.create')->middleware(['permission:create_party']);
        Route::post('/store', 'store')->name('sub-ledger.store')->middleware(['permission:create_party']);
        Route::get('/edit/{id}', 'edit')->name('sub-ledger.edit')->middleware(['permission:edit_party']);
        Route::get('/show/{id}', 'show')->name('sub-ledger.show')->middleware(['permission:view_party']);
        Route::post('/update/{id}', 'update')->name('sub-ledger.update')->middleware(['permission:edit_party']);
        Route::post('/delete', 'destroy')->name('sub-ledger.delete')->middleware(['permission:delete_party']);
        Route::get('/transactional-account-list-ajax', 'transactional_list_for_select_ajax')->name('sub-ledger.transactional_list_for_select');
    });
    Route::controller(WorkOrderController::class)->prefix('/work-order')->group(function () {
        Route::get('/index', 'index')->name('work-order.index')->middleware(['permission:view_work_order']);
        Route::get('/create', 'create')->name('work-order.create')->middleware(['permission:create_work_order']);
        Route::post('/store', 'store')->name('work-order.store')->middleware(['permission:create_work_order']);
        Route::get('/edit/{id}', 'edit')->name('work-order.edit')->middleware(['permission:edit_work_order']);
        Route::get('/show/{id}', 'show')->name('work-order.show')->middleware(['permission:view_work_order']);
        Route::post('/update/{id}', 'update')->name('work-order.update')->middleware(['permission:edit_work_order']);
        Route::post('/delete', 'destroy')->name('work-order.delete')->middleware(['permission:delete_work_order']);
        Route::get('/work-order-list-ajax', 'list_for_select_ajax')->name('work-order.list_for_select');
        Route::get('/work-order-estimation-cost-row', 'get_row')->name('work-order.get_row');
        Route::get('/work-order-profit-loss-report', 'profit_loss_report')->name('work-orders.pl_report')->middleware(['permission:']);
        Route::get('/work-order-balance-sheet-report', 'balance_sheet_report')->name('work-orders.balance_sheet_report')->middleware(['permission:']);
        Route::get('/receive-payment-report', 'receive_payment_report')->name('work-orders.receive_payment_report')->middleware(['permission:']);
    });
    Route::controller(WorkOrderSiteController::class)->prefix('/work-order-sites')->group(function () {
        Route::get('/index', 'index')->name('work-order-sites.index')->middleware(['permission:view_work_order_site']);
        Route::get('/create', 'create')->name('work-order-sites.create')->middleware(['permission:create_work_order_site']);
        Route::post('/store', 'store')->name('work-order-sites.store')->middleware(['permission:create_work_order_site']);
        Route::get('/edit/{id}', 'edit')->name('work-order-sites.edit')->middleware(['permission:edit_work_order_site']);
        Route::get('/show/{id}', 'show')->name('work-order-sites.show')->middleware(['permission:view_work_order_site']);
        Route::post('/update/{id}', 'update')->name('work-order-sites.update')->middleware(['permission:edit_work_order_site']);
        Route::post('/delete', 'destroy')->name('work-order-sites.delete')->middleware(['permission:delete_work_order_site']);
        Route::get('/work-order-list-ajax', 'list_for_select_ajax')->name('work-order-sites.list_for_select');
    });
    Route::controller(CashPaymentJournalController::class)->prefix('/cash-payment-journal')->group(function () {
        Route::get('/index', 'index')->name('multi-cash-payment.index')->middleware(['permission:view_cash_payment']);
        Route::get('/create', 'create')->name('multi-cash-payment.create')->middleware(['permission:create_cash_payment']);
        Route::post('/store', 'store')->name('multi-cash-payment.store')->middleware(['permission:create_cash_payment']);
        Route::get('/edit/{id}', 'edit')->name('multi-cash-payment.edit')->middleware(['permission:edit_cash_payment']);
        Route::get('/show/{id}', 'show')->name('multi-cash-payment.show')->middleware(['permission:view_cash_payment']);
        Route::post('/update/{id}', 'update')->name('multi-cash-payment.update')->middleware(['permission:edit_cash_payment']);
        Route::post('/delete', 'destroy')->name('multi-cash-payment.delete')->middleware(['permission:delete_cash_payment']);
        Route::get('/add-new-row-cr-entry', 'add_new_line_cr')->name('multi-cash-payment.add_new_line_cr');
        Route::get('/print/{id}', 'print')->name('multi-cash-payment.print')->middleware(['permission:view_cash_payment']);
    });
    Route::controller(BankPaymentJournalController::class)->prefix('/bank-payment-journal')->group(function () {
        Route::get('/index', 'index')->name('multi-bank-payment.index')->middleware(['permission:view_bank_payment']);
        Route::get('/create', 'create')->name('multi-bank-payment.create')->middleware(['permission:create_bank_payment']);
        Route::post('/store', 'store')->name('multi-bank-payment.store')->middleware(['permission:create_bank_payment']);
        Route::get('/edit/{id}', 'edit')->name('multi-bank-payment.edit')->middleware(['permission:edit_bank_payment']);
        Route::get('/show/{id}', 'show')->name('multi-bank-payment.show')->middleware(['permission:view_bank_payment']);
        Route::post('/update/{id}', 'update')->name('multi-bank-payment.update')->middleware(['permission:edit_bank_payment']);
        Route::post('/delete', 'destroy')->name('multi-bank-payment.delete')->middleware(['permission:delete_bank_payment']);
        Route::get('/add-new-row-cr-entry', 'add_new_line_cr')->name('multi-bank-payment.add_new_line_cr');
        Route::get('/print/{id}', 'print')->name('multi-bank-payment.print')->middleware(['permission:view_bank_payment']);
    });
    Route::controller(CashReceiveJournalController::class)->prefix('/cash-receive-journal')->group(function () {
        Route::get('/index', 'index')->name('multi-cash-receive.index')->middleware(['permission:view_cash_recieve']);
        Route::get('/create', 'create')->name('multi-cash-receive.create')->middleware(['permission:create_cash_recieve']);
        Route::post('/store', 'store')->name('multi-cash-receive.store')->middleware(['permission:create_cash_recieve']);
        Route::get('/edit/{id}', 'edit')->name('multi-cash-receive.edit')->middleware(['permission:edit_cash_recieve']);
        Route::get('/show/{id}', 'show')->name('multi-cash-receive.show')->middleware(['permission:view_cash_recieve']);
        Route::post('/update/{id}', 'update')->name('multi-cash-receive.update')->middleware(['permission:edit_cash_recieve']);
        Route::post('/delete', 'destroy')->name('multi-cash-receive.delete')->middleware(['permission:delete_cash_recieve']);
        Route::get('/add-new-row-cr-entry', 'add_new_line_cr')->name('multi-cash-receive.add_new_line_cr');
        Route::get('/print/{id}', 'print')->name('multi-cash-receive.print')->middleware(['permission:view_cash_recieve']);
    });
    Route::controller(BankReceiveJournalController::class)->prefix('/bank-receive-journal')->group(function () {
        Route::get('/index', 'index')->name('multi-bank-receive.index')->middleware(['permission:view_bank_recieve']);
        Route::get('/create', 'create')->name('multi-bank-receive.create')->middleware(['permission:create_bank_recieve']);
        Route::post('/store', 'store')->name('multi-bank-receive.store')->middleware(['permission:create_bank_recieve']);
        Route::get('/edit/{id}', 'edit')->name('multi-bank-receive.edit')->middleware(['permission:edit_bank_recieve']);
        Route::get('/show/{id}', 'show')->name('multi-bank-receive.show')->middleware(['permission:view_bank_recieve']);
        Route::post('/update/{id}', 'update')->name('multi-bank-receive.update')->middleware(['permission:edit_bank_recieve']);
        Route::post('/delete', 'destroy')->name('multi-bank-receive.delete')->middleware(['permission:delete_bank_recieve']);
        Route::get('/add-new-row-cr-entry', 'add_new_line_cr')->name('multi-bank-receive.add_new_line_cr');
        Route::get('/print/{id}', 'print')->name('multi-bank-receive.print')->middleware(['permission:view_bank_recieve']);
    });
    Route::controller(JournalController::class)->prefix('/general-journal')->group(function () {
        Route::get('/index', 'index')->name('journal.index')->middleware(['permission:view_journal']);
        Route::get('/create', 'create')->name('journal.create')->middleware(['permission:create_journal']);
        Route::post('/store', 'store')->name('journal.store')->middleware(['permission:create_journal']);
        Route::get('/edit/{id}', 'edit')->name('journal.edit')->middleware(['permission:edit_journal']);
        Route::get('/show/{id}', 'show')->name('journal.show')->middleware(['permission:view_journal']);
        Route::post('/update/{id}', 'update')->name('journal.update')->middleware(['permission:edit_journal']);
        Route::post('/delete', 'destroy')->name('journal.delete')->middleware(['permission:delete_journal']);
        Route::get('/add-new-row-entry', 'add_new_line')->name('journal.add_new_line');
        Route::get('/print/{id}', 'print')->name('journal.print')->middleware(['permission:view_journal']);
    });
    Route::controller(OpeningBalanceController::class)->prefix('/opening-balance')->group(function () {
        Route::get('/index', 'index')->name('opening-balance.index')->middleware(['permission:view_opening_balance']);
        Route::get('/create', 'create')->name('opening-balance.create')->middleware(['permission:create_opening_balance']);
        Route::post('/store', 'store')->name('opening-balance.store')->middleware(['permission:create_opening_balance']);
        Route::get('/edit/{id}', 'edit')->name('opening-balance.edit')->middleware(['permission:edit_opening_balance']);
        Route::get('/show/{id}', 'show')->name('opening-balance.show')->middleware(['permission:view_opening_balance']);
        Route::post('/update/{id}', 'update')->name('opening-balance.update')->middleware(['permission:edit_opening_balance']);
        Route::post('/delete', 'destroy')->name('opening-balance.delete')->middleware(['permission:delete_opening_balance']);
        Route::get('/print/{id}', 'print')->name('opening-balance.print')->middleware(['permission:view_opening_balance']);
    });
    Route::controller(AccountsController::class)->prefix('configuration')->group(function () {
        Route::get('/report', 'report_config')->name('accountings.report-config')->middleware(['permission:accounting_report_config']);
        Route::post('/general-store', 'general_config_store')->name('accountings.general-config-store')->middleware(['permission:accounting_report_config']);
    });
    Route::controller(AccountsPeriodController::class)->group(function () {
        Route::get('/day-closing', 'day_closing_list')->name('accountings.day_closing_list')->middleware(['permission:day_closing']);
        Route::get('/day-closing-current-date', 'day_closing_current_date')->name('accountings.day_closing_current_date')->middleware(['permission:day_closing']);
        Route::post('/day-closing-now', 'day_closing_confirm')->name('accountings.day_closing_confirm')->middleware(['permission:day_closing']);
        Route::get('/day-closing-check/{id}', 'day_closing_check')->name('accountings.day_closing_check')->middleware(['permission:day_closing']);
    });
    Route::controller(JournalWorkOrderController::class)->prefix('/journal/work-order-based')->group(function () {
        Route::get('/index', 'index')->name('journal.work_order.index')->middleware(['permission:view_work_order_journal']);
        Route::get('/create', 'create')->name('journal.work_order.create')->middleware(['permission:create_work_order_journal']);
        Route::post('/store', 'store')->name('journal.work_order.store')->middleware(['permission:create_work_order_journal']);
        Route::get('/edit/{id}', 'edit')->name('journal.work_order.edit')->middleware(['permission:edit_work_order_journal']);
        Route::get('/show/{id}', 'show')->name('journal.work_order.show')->middleware(['permission:view_work_order_journal']);
        Route::post('/update/{id}', 'update')->name('journal.work_order.update')->middleware(['permission:edit_work_order_journal']);
        Route::post('/delete', 'destroy')->name('journal.work_order.delete')->middleware(['permission:delete_work_order_journal']);
        Route::get('/print/{id}', 'print')->name('journal.work_order.print')->middleware(['permission:view_work_order_journal']);
    });
    Route::controller(VouchersController::class)->prefix('/voucher-approval')->group(function () {
        Route::get('/index', 'approval_index')->name('voucher.approval_index')->middleware(['permission:view_pending_vocuher']);
        Route::get('/show/{id}', 'show')->name('voucher.show')->middleware(['permission:view_pending_vocuher']);
        Route::post('/delete', 'destroy')->name('voucher.delete')->middleware(['permission:approval_vocuher']);
        Route::post('/approve-now', 'approve_now')->name('voucher.approve_now')->middleware(['permission:approval_vocuher']);
        Route::post('/multiple-approve-now', 'multiple_approve_now')->name('voucher.multiple_approve_now')->middleware(['permission:approval_vocuher']);
        Route::get('/accountant', 'rejected_by_accountant_index')->name('reject_by_accountant.index')->middleware(['permission:view_rejected_vocuher']);
    });
    Route::controller(AccountsController::class)->prefix('/reports')->group(function () {
        Route::get('/cashbook', 'cashbook')->name('accountings.cashbook')->middleware(['permission:cashbook_report']);
        Route::get('/bankbook', 'bankbook')->name('accountings.bankbook')->middleware(['permission:bankbook_report']);
        Route::get('/ledger-report', 'ledger_report')->name('accountings.ledger_report')->middleware(['permission:ledger_report']);
        Route::get('/party-accounts-report', 'sub_ledger_report')->name('accountings.sub_ledger_report')->middleware(['permission:party_report']);
        Route::get('/party-accounts-summary-report', 'sub_ledger_summary_report')->name('accountings.sub_ledger_summary_report')->middleware(['permission:party_summary_report']);
        Route::get('/work-order-report', 'work_order_report')->name('accountings.work_order_report')->middleware(['permission:work_order_report']);
        Route::get('/work-order-summary-report', 'work_order_summary_report')->name('accountings.work_order_summary_report')->middleware(['permission:work_order_summary_report']);
        Route::get('/receive-payment-report', 'receive_payment_report')->name('accountings.receive_payment_report')->middleware(['permission:reciept_payemnt_report']);
    });
    Route::controller(BalanceSheetController::class)->prefix('report')->as('accountings.')->group(function () {
        Route::get('/balances-sheet', 'balancesheet')->name('balancesheet')->middleware(['permission:balancesheet_report']);
    });
    Route::controller(IncomeStatementController::class)->prefix('report')->as('accountings.')->group(function () {
        Route::get('/income-statement', 'income_statement')->name('income_statement')->middleware(['permission:income_statement_report']);
    });
    Route::controller(TrialBalanceController::class)->prefix('report')->as('accountings.')->group(function () {
        Route::get('/trial-balance', 'trial_balance')->name('trial_balance')->middleware(['permission:trial_report']);
    });
    Route::controller(LedgerDetailsReportController::class)->prefix('report')->as('accountings.')->group(function () {
        Route::get('/ledger-report-details-based-on-data', 'detail_report_ledger')->name('ledger_report_details_specific_filter')->middleware(['permission:ledger_report']);
    });

    
    Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::get('/index', 'index')->name('products.index')->middleware(['permission:view_product']);
        Route::get('/create', 'create')->name('products.create')->middleware(['permission:create_product']);
        Route::post('/store', 'store')->name('products.store')->middleware(['permission:create_product']);
        Route::get('/edit/{id}', 'edit')->name('products.edit')->middleware(['permission:edit_product']);
        Route::get('/show/{id}', 'show')->name('products.show')->middleware(['permission:view_product']);
        Route::post('/get-details-for-purchase', 'get_detail_purchase')->name('products.get_detail_purchase');
        Route::post('/get-details-for-sale', 'get_detail_sale')->name('products.get_detail_sale');
        Route::post('/update/{id}', 'update')->name('products.update')->middleware(['permission:edit_product']);
        Route::post('/delete', 'destroy')->name('products.delete')->middleware(['permission:delete_product']);
        Route::get('/list-ajax', 'list_for_select')->name('products.list_for_select');
    });
    Route::controller(ProductUnitController::class)->prefix('products-unit')->group(function () {
        Route::get('/index', 'index')->name('products-unit.index')->middleware(['permission:view_product_unit']);
        Route::get('/create', 'create')->name('products-unit.create')->middleware(['permission:create_product_unit']);
        Route::post('/store', 'store')->name('products-unit.store')->middleware(['permission:create_product_unit']);
        Route::get('/edit/{id}', 'edit')->name('products-unit.edit')->middleware(['permission:edit_product_unit']);
        Route::get('/show/{id}', 'show')->name('products-unit.show')->middleware(['permission:view_product_unit']);
        Route::post('/update/{id}', 'update')->name('products-unit.update')->middleware(['permission:edit_product_unit']);
        Route::post('/delete', 'destroy')->name('products-unit.delete')->middleware(['permission:delete_product_unit']);
        Route::get('/list-ajax', 'list_for_select')->name('products-unit.list_for_select');
    });
    Route::controller(SaleController::class)->prefix('sales')->group(function () {
        Route::get('/index', 'index')->name('sales.index')->middleware(['permission:view_sales']);
        Route::get('/create', 'create')->name('sales.create')->middleware(['permission:create_sales']);
        Route::post('/store', 'store')->name('sales.store')->middleware(['permission:create_sales']);
        Route::get('/edit/{id}', 'edit')->name('sales.edit')->middleware(['permission:edit_sales']);
        Route::get('/show/{id}', 'show')->name('sales.show')->middleware(['permission:view_sales']);
        Route::get('/print/{id}', 'print')->name('sales.print')->middleware(['permission:view_sales']);
        Route::post('/update/{id}', 'update')->name('sales.update')->middleware(['permission:edit_sales']);
        Route::post('/delete', 'destroy')->name('sales.delete')->middleware(['permission:delete_sales']);
        Route::post('/approval-status-approve', 'approve_status')->name('sales.approve_status')->middleware(['permission:approve_sales']);
        Route::get('/list-ajax', 'list_for_select')->name('sales.list_for_select');
    });
    Route::controller(PurchaseController::class)->prefix('purchase')->group(function () {
        Route::get('/index', 'index')->name('purchases.index')->middleware(['permission:view_purcahse']);
        Route::get('/create', 'create')->name('purchases.create')->middleware(['permission:create_purcahse']);
        Route::post('/store', 'store')->name('purchases.store')->middleware(['permission:create_purcahse']);
        Route::get('/edit/{id}', 'edit')->name('purchases.edit')->middleware(['permission:edit_purcahse']);
        Route::get('/show/{id}', 'show')->name('purchases.show')->middleware(['permission:view_purcahse']);
        Route::get('/print/{id}', 'print')->name('purchases.print')->middleware(['permission:view_purcahse']);
        Route::post('/update/{id}', 'update')->name('purchases.update')->middleware(['permission:edit_purcahse']);
        Route::post('/delete', 'destroy')->name('purchases.delete')->middleware(['permission:delete_purcahse']);
        Route::post('/approval-status-approve', 'approve_status')->name('purchases.approve_status')->middleware(['permission:approve_purcahse']);
        Route::get('/list-ajax', 'list_for_select')->name('purchases.list_for_select');
    });
    Route::controller(QuotationController::class)->prefix('quotations')->group(function () {
        Route::get('/index', 'index')->name('quotations.index')->middleware(['permission:view_quotation']);
        Route::get('/create', 'create')->name('quotations.create')->middleware(['permission:create_quotation']);
        Route::post('/store', 'store')->name('quotations.store')->middleware(['permission:create_quotation']);
        Route::get('/edit/{id}', 'edit')->name('quotations.edit')->middleware(['permission:edit_quotation']);
        Route::get('/convert-to-sale/{id}', 'convert_to_sale')->name('quotations.convert_to_sale')->middleware(['permission:create_sales']);
        Route::get('/show/{id}', 'show')->name('quotations.show')->middleware(['permission:view_quotation']);
        Route::get('/print/{id}', 'print')->name('quotations.print')->middleware(['permission:view_quotation']);
        Route::post('/update/{id}', 'update')->name('quotations.update')->middleware(['permission:edit_quotation']);
        Route::post('/delete', 'destroy')->name('quotations.delete')->middleware(['permission:delete_quotation']);
        Route::post('/approval-status-approve', 'approve_status')->name('quotations.approve_status')->middleware(['permission:approve_quotation']);
        Route::get('/list-ajax', 'list_for_select')->name('quotations.list_for_select');
    });


});
