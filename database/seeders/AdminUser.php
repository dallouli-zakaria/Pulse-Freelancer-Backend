<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@pulse.com',
            'password' => Hash::make('admin123'),
        ]);

        // Assign the admin role to the user
        $admin->assignRole('superadmin_role');
    }
}
