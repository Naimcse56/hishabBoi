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
    }
}
