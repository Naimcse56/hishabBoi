<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'view_product','label' => 'view product', 'sub_module' => 'product', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_product','label' => 'edit product',  'sub_module' => 'product', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_product','label' => 'delete product', 'sub_module' => 'product', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_product', 'label' => 'create product', 'sub_module' => 'product', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_product_unit','label' => 'view product unit', 'sub_module' => 'product unit', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_product_unit','label' => 'edit product unit',  'sub_module' => 'product unit', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_product_unit','label' => 'delete product unit', 'sub_module' => 'product unit', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_product_unit', 'label' => 'create product unit', 'sub_module' => 'product unit', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_quotation','label' => 'view quotation', 'sub_module' => 'quotation', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_quotation','label' => 'edit quotation',  'sub_module' => 'quotation', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_quotation','label' => 'delete quotation', 'sub_module' => 'quotation', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_quotation', 'label' => 'create quotation', 'sub_module' => 'quotation', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'approve_quotation', 'label' => 'approve quotation', 'sub_module' => 'quotation', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_sales','label' => 'view sales', 'sub_module' => 'sales', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_sales','label' => 'edit sales',  'sub_module' => 'sales', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_sales','label' => 'delete sales', 'sub_module' => 'sales', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_sales', 'label' => 'create sales', 'sub_module' => 'sales', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'approve_sales', 'label' => 'approve sales', 'sub_module' => 'sales', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_purcahse','label' => 'view purcahse', 'sub_module' => 'purcahse', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_purcahse','label' => 'edit purcahse',  'sub_module' => 'purcahse', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_purcahse','label' => 'delete purcahse', 'sub_module' => 'purcahse', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_purcahse', 'label' => 'create purcahse', 'sub_module' => 'purcahse', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'approve_purcahse', 'label' => 'approve purcahse', 'sub_module' => 'purcahse', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_ledger','label' => 'view ledger', 'sub_module' => 'ledger', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_ledger','label' => 'edit ledger',  'sub_module' => 'ledger', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_ledger','label' => 'delete ledger', 'sub_module' => 'ledger', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_ledger', 'label' => 'create ledger', 'sub_module' => 'ledger', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_party_type','label' => 'view party type', 'sub_module' => 'party type', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_party_type','label' => 'edit party type',  'sub_module' => 'party type', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_party_type','label' => 'delete party type', 'sub_module' => 'party type', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_party_type', 'label' => 'create party type', 'sub_module' => 'party type', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_party','label' => 'view party', 'sub_module' => 'party', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_party','label' => 'edit party',  'sub_module' => 'party', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_party','label' => 'delete party', 'sub_module' => 'party', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_party', 'label' => 'create party', 'sub_module' => 'party', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_work_order','label' => 'view work order', 'sub_module' => 'work order', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_work_order','label' => 'edit work order',  'sub_module' => 'work order', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_work_order','label' => 'delete work order', 'sub_module' => 'work order', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_work_order', 'label' => 'create work order', 'sub_module' => 'work order', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_work_order_site','label' => 'view work order sites', 'sub_module' => 'work order sites', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_work_order_site','label' => 'edit work order sites',  'sub_module' => 'work order sites', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_work_order_site','label' => 'delete work order sites', 'sub_module' => 'work order sites', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_work_order_site', 'label' => 'create work order sites', 'sub_module' => 'work order sites', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_cash_payment','label' => 'view cash payment', 'sub_module' => 'cash payment', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_cash_payment','label' => 'edit cash payment',  'sub_module' => 'cash payment', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_cash_payment','label' => 'delete cash payment', 'sub_module' => 'cash payment', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_cash_payment', 'label' => 'create cash payment', 'sub_module' => 'cash payment', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_bank_payment','label' => 'view bank payment', 'sub_module' => 'bank payment', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_bank_payment','label' => 'edit bank payment',  'sub_module' => 'bank payment', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_bank_payment','label' => 'delete bank payment', 'sub_module' => 'bank payment', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_bank_payment', 'label' => 'create bank payment', 'sub_module' => 'bank payment', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_cash_recieve','label' => 'view cash recieve', 'sub_module' => 'cash recieve', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_cash_recieve','label' => 'edit cash recieve',  'sub_module' => 'cash recieve', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_cash_recieve','label' => 'delete cash recieve', 'sub_module' => 'cash recieve', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_cash_recieve', 'label' => 'create cash recieve', 'sub_module' => 'cash recieve', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_bank_recieve','label' => 'view bank recieve', 'sub_module' => 'bank recieve', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_bank_recieve','label' => 'edit bank recieve',  'sub_module' => 'bank recieve', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_bank_recieve','label' => 'delete bank recieve', 'sub_module' => 'bank recieve', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_bank_recieve', 'label' => 'create bank recieve', 'sub_module' => 'bank recieve', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_journal','label' => 'view journal', 'sub_module' => 'journal', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_journal','label' => 'edit journal',  'sub_module' => 'journal', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_journal','label' => 'delete journal', 'sub_module' => 'journal', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_journal', 'label' => 'create journal', 'sub_module' => 'journal', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_work_order_journal','label' => 'view work order journal', 'sub_module' => 'work order journal', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_work_order_journal','label' => 'edit work order journal',  'sub_module' => 'work order journal', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_work_order_journal','label' => 'delete work order journal', 'sub_module' => 'work order journal', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_work_order_journal', 'label' => 'create work order journal', 'sub_module' => 'work order journal', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_opening_balance','label' => 'view opening balance', 'sub_module' => 'opening balance', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_opening_balance','label' => 'edit opening balance',  'sub_module' => 'opening balance', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_opening_balance','label' => 'delete opening balance', 'sub_module' => 'opening balance', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_opening_balance', 'label' => 'create opening balance', 'sub_module' => 'opening balance', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_pending_vocuher','label' => 'view pending voucher', 'sub_module' => 'voucher approval', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'view_rejected_vocuher','label' => 'view rejected voucher ',  'sub_module' => 'voucher approval', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'approval_vocuher','label' => 'approve voucher ',  'sub_module' => 'voucher approval', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],

            ['name' => 'cashbook_report','label' => 'cashbook report', 'sub_module' => 'Accounting Report', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'bankbook_report','label' => 'bankbook report', 'sub_module' => 'Accounting Report', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ledger_report','label' => 'ledger report', 'sub_module' => 'Accounting Report', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'party_report','label' => 'party report', 'sub_module' => 'Accounting Report', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'party_summary_report','label' => 'party summary report', 'sub_module' => 'Accounting Report', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'work_order_report','label' => 'work order report', 'sub_module' => 'Accounting Report', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'work_order_summary_report','label' => 'work order summary report', 'sub_module' => 'Accounting Report', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'work_order_pl_report','label' => 'work order Profit Loss report', 'sub_module' => 'Accounting Report', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'work_order_asset_liability_report','label' => 'work order Asset Liability report', 'sub_module' => 'Accounting Report', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'work_order_reciept_payemnt_report','label' => 'work order reciept payment report', 'sub_module' => 'Accounting Report', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'reciept_payemnt_report','label' => 'reciept payment report', 'sub_module' => 'Accounting Report', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'balancesheet_report','label' => 'balancesheet report', 'sub_module' => 'Accounting Report', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'income_statement_report','label' => 'income statement report', 'sub_module' => 'Accounting Report', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'trial_report','label' => 'trial report', 'sub_module' => 'Accounting Report', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'accounting_report_config','label' => 'accounting report config', 'sub_module' => 'accounting configuration', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'day_closing','label' => 'day closing',  'sub_module' => 'accounting configuration', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_users','label' => 'view staff', 'sub_module' => 'Staff', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_users','label' => 'edit staff',  'sub_module' => 'Staff', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_users','label' => 'delete staff', 'sub_module' => 'Staff', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_users', 'label' => 'create staff', 'sub_module' => 'Staff', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_designation','label' => 'view designation', 'sub_module' => 'designation', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_designation','label' => 'edit designation',  'sub_module' => 'designation', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_designation','label' => 'delete designation', 'sub_module' => 'designation', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_designation', 'label' => 'create designation', 'sub_module' => 'designation', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_department','label' => 'view department', 'sub_module' => 'department', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_department','label' => 'edit department',  'sub_module' => 'department', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_department','label' => 'delete department', 'sub_module' => 'department', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_department', 'label' => 'create department', 'sub_module' => 'department', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'staff_permission','label' => 'staff permission', 'sub_module' => 'permission', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'company_settings','label' => 'company settings', 'sub_module' => 'company settings', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'general_settings','label' => 'general settings', 'sub_module' => 'general settings', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'email_settings','label' => 'email settings', 'sub_module' => 'email settings', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'sales_purchase_settings','label' => 'sales purchase settings', 'sub_module' => 'sales purchase settings', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_language','label' => 'view language', 'sub_module' => 'language', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_language','label' => 'edit language',  'sub_module' => 'language', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_language','label' => 'delete language', 'sub_module' => 'language', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_language', 'label' => 'create language', 'sub_module' => 'language', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'view_currency','label' => 'view currency', 'sub_module' => 'Currency', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_currency','label' => 'edit currency',  'sub_module' => 'Currency', 'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_currency','label' => 'delete currency', 'sub_module' => 'Currency', 'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_currency', 'label' => 'create currency', 'sub_module' => 'Currency', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
        ];

        // Insert permissions into the database
        DB::table('permissions')->insert($permissions);
        $user = User::first();

        // Assign the permissions to the user
        $user->syncPermissions(Permission::all());
    }
}
