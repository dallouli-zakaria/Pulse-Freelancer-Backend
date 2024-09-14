<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'client_role', 'guard_name' => 'api']);
        Role::firstOrCreate(['name' => 'freelancer_role', 'guard_name' => 'api']);
        Role::firstOrCreate(['name' => 'admin_role', 'guard_name' => 'api']);
        Role::firstOrCreate(['name' => 'superadmin_role', 'guard_name' => 'api']);
    }
}
