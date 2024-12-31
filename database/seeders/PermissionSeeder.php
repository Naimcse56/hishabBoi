<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            ['name' => 'view_users','label' => 'view users',  'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_users','label' => 'edit users',   'guard_name' => 'web','created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_users','label' => 'delete users',  'guard_name' => 'web',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create_users', 'label' => 'create users',  'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
        ];

        // Insert permissions into the database
        DB::table('permissions')->insert($permissions);
    }
}
