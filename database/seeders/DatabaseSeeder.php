<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Accounts\Database\Seeders\LedgerSeeder;
use Modules\Accounts\Database\Seeders\DayCloseSeeder;
use Modules\Accounts\Database\Seeders\SubLedgerTypeSeeder;
use Database\Seeders\PermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(PermissionSeeder::class);
        $this->call(LedgerSeeder::class);
        $this->call(SubLedgerTypeSeeder::class);
        $this->call(DayCloseSeeder::class);
    }
}
