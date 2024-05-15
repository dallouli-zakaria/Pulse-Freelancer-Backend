<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


            //grant all permissions to role super admin

        // find super-admin role
        $superAdminRole = Role::where('name', 'super-admin')->first();

        // Get all permissions
        $permissions = Permission::all();
                    
        // Assign all permissions to super-admin role
        $superAdminRole->syncPermissions($permissions->all());



        
    }
}
