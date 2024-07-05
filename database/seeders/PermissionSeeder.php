<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     *Run the database seeds.
     */
    public function run(): void
    { 
        Permission::create(['name' => 'create_post']);
        Permission::create(['name' => 'edit_post']);
        Permission::create(['name' => 'delete_post']);
    
    }
}