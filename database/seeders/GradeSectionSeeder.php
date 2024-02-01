<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GradeSection;

class GradeSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gradelevel_section = GradeSection::create([
            'grade_level' => 'Grade 7',
            'section' => 'Rizal',
        ]);
        $gradelevel_section = GradeSection::create([
            'grade_level' => 'Grade 8',
            'section' => 'Luna',
        ]);
        $gradelevel_section = GradeSection::create([
            'grade_level' => 'Grade 9',
            'section' => 'Aguinaldo',
        ]);
        $gradelevel_section = GradeSection::create([
            'grade_level' => 'Grade 10',
            'section' => 'Del Pilar',
        ]);
        $gradelevel_section = GradeSection::create([
            'grade_level' => 'Grade 11',
            'section' => 'STEM-11A',
        ]);
        $gradelevel_section = GradeSection::create([
            'grade_level' => 'Grade 12',
            'section' => 'ABM-12A',
        ]);
    }
}
