<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        $adminRole = Role::create(['name' => 'admin']);

        // Create a new permission
       Permission::insert([
            ['name' => 'add_user'],
            ['name' => 'update_user'],
            ['name' => 'delete_user'],
        ]);
        
        // permission to the admin role
    
        $permissionIds = Permission::pluck('id');

        // Assign permissions to the admin role
        foreach ($permissionIds as $permissionId) {
            DB::table('role_permission')->insert([
                'role_id' => $adminRole->id,
                'permission_id' => $permissionId
            ]);
     
   

    }
}
}