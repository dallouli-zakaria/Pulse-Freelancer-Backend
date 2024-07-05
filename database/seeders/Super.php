<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Super extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::where('name', 'super-admin')->first();

        // Get all permissions
        $permissions = Permission::all();
               
        // Assign all permissions to super-admin role -- TO FIX
        $superAdminRole->syncPermissions($permissions->all());



    }
}
