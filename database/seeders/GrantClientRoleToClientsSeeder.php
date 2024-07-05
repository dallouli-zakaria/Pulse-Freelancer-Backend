<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class GrantClientRoleToClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $clients = Client::all();
        // $clientRole = Role::where('name', 'client_role')->where('guard_name', 'api')->first();

        // foreach ($clients as $client) {
        //     $client->assignRole($clientRole);
        // }
    }
}
