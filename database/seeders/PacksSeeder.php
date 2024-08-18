<?php

namespace Database\Seeders;

use App\Models\Pack;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PacksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            Pack::create([
            'title' => 'Gratuit',
            'description' => 'pack gratuit',
            'price'=>0

        ]);
        Pack::create([
            'title' => 'Premium',
            'description' => 'Pack premium avec plus de fonctionnalités',
            'price'=>99

        ]);
        Pack::create([
            'title' => 'Entreprise',
            'description' => 'Pack entreprise avec toutes les fonctionnalités',
            'price'=>399

        ]);
    }
}
