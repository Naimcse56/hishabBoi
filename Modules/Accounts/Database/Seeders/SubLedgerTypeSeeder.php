<?php

namespace Modules\Accounts\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubLedgerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {      
      DB::table('sub_ledger_types')->insert(array (
         0 => array(
            'is_for' => 1,
            'name' => 'Logistics & Supply-Payable',
         ),
         1 => array(
            'is_for' => 1,
            'name' => 'Civil Vendors & Suppliers (Payable)',
         ),
         2 => array(
            'is_for' => 1,
            'name' => 'Corporate Vendors (Payable)',
         ),
         3 => array(
            'is_for' => 2,
            'name' => 'Premium Customer',
         ),
         4 => array(
            'is_for' => 0,
            'name' => 'In-House Staff',
         ),
      ));
    }
}
