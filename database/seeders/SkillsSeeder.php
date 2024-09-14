<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            'JavaScript', 'PHP', 'Python', 'Java', 'C#', 'Angular', 'React',
            'Vue.js', 'Node.js', 'Ruby on Rails', 'Django', 'Laravel', 'Spring',
            'C++', 'Swift', 'Kotlin', 'SQL', 'NoSQL', 'HTML', 'CSS', 'Sass',
            'LESS', 'TypeScript', 'jQuery', 'Bootstrap', 'Tailwind CSS', 'GraphQL',
            'RESTful APIs', 'AWS', 'Azure', 'Google Cloud', 'DevOps', 'Docker',
            'Kubernetes', 'CI/CD', 'Agile', 'Scrum', 'JIRA', 'Git', 'GitHub',
            'Bitbucket', 'SVN', 'MySQL', 'PostgreSQL', 'MongoDB', 'Firebase',
            'Elasticsearch', 'Redis', 'Linux', 'Windows Server', 'Network Security',
            'Penetration Testing', 'Machine Learning', 'Deep Learning', 'NLP',
            'Computer Vision', 'TensorFlow', 'PyTorch', 'Scikit-learn', 'Pandas',
            'NumPy', 'Big Data', 'Hadoop', 'Spark', 'Data Analysis', 'Data Visualization',
            'Tableau', 'Power BI', 'Excel', 'MATLAB', 'R', 'SAS', 'Business Intelligence',
            'ETL', 'Data Warehousing', 'Data Mining', 'Blockchain', 'Cryptography',
            'Quantum Computing', 'IoT', 'Embedded Systems', 'Arduino', 'Raspberry Pi',
            'Game Development', 'Unity', 'Unreal Engine', 'VR/AR', '3D Modeling',
            'AutoCAD', 'SketchUp', 'Blender', 'Photoshop', 'Illustrator', 'Figma',
            'UX/UI Design', 'Web Design', 'Mobile App Development', 'Android',
            'iOS', 'Cross-Platform', 'Flutter', 'Xamarin', 'React Native'
        ];

        $timestamp = Carbon::now();

        foreach ($skills as $skill) {
            DB::table('skills')->insert([
                'title' => $skill,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ]);
        }
    }
}
