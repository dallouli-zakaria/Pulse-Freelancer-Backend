<?php

namespace Database\Seeders;

use App\Models\skills;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            ['title' => 'PHP'],
            ['title' => 'JavaScript'],
            ['title' => 'HTML'],
            ['title' => 'CSS'],
            ['title' => 'Python'],
            ['title' => 'React'],
            ['title' => 'Angular'],
        
        ];

        foreach ($skills as &$skill) {
            $skill['created_at'] = now();
            $skill['updated_at'] = now();
        }

        skills::insert($skills);
    
    }
}
