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
    }
}
