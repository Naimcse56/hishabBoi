<?php

namespace Modules\Accounts\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\App\Models\DayCloseFiscalYear;
use Modules\Accounts\App\Models\FiscalYear;
use Carbon\Carbon;

class DayCloseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $fiscalYear = FiscalYear::create(['from_date' => now(),'year'=>'24-25']);
      $dayCloseFiscalYear = DayCloseFiscalYear::create(['fiscal_year_id' => $fiscalYear->id, 'from_date' => now()]);
      DB::table('account_configurations')->insert(array(
          0 => array(
            'name' => 'inc_st_first_section',
            'value' => '24',
          ),
          1 => array(
            'name' => 'inc_st_second_section',
            'value' => '16',
          ),
          2 => array(
            'name' => 'inc_st_third_section',
            'value' => '19',
          ),
          3 => array(
            'name' => 'inc_st_fourth_section',
            'value' => '26',
          ),
          4 => array(
            'name' => 'inc_st_fifth_section',
            'value' => '28',
          ),
          5 => array(
            'name' => 'inc_st_six_section',
            'value' => '25',
          ),
          6 => array(
            'name' => 'inc_st_seven_section',
            'value' => '25',
          ),
          7 => array(
            'name' => 'inc_st_tax_expenses_section',
            'value' => '20',
          ),
          8 => array(
            'name' => 'balance_sht_first_section',
            'value' => '2',
          ),
          9 => array(
            'name' => 'balance_sht_second_section',
            'value' => '3',
          ),
          10 => array(
            'name' => 'balance_sht_third_section',
            'value' => '10',
          ),
          11 => array(
            'name' => 'balance_sht_fourth_section',
            'value' => '31',
          ),
          12 => array(
            'name' => 'balance_sht_fifth_section',
            'value' => '12',
          ),
          13 => array(
            'name' => 'balance_sht_six_section',
            'value' => '0',
          ),
          14 => array(
            'name' => 'balance_sht_seven_section',
            'value' => '0',
          ),
          15 => array(
            'name' => 'retail_earning_account',
            'value' => '0',
          ),
      ));
    }
}
