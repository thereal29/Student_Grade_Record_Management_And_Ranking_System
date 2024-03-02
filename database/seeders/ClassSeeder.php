<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classes;
use App\Models\ClassAdvisory;
use App\Models\StudentSubjects;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        
        $class = Classes::create([
            'student_subject_id' => '1',
            'faculty_id' => '3',
            'sy_id' => '1',
        ]);

        $class_advisory = ClassAdvisory::create([
            'faculty_id' => '3',
            'glevel_section_id' => '1',
            'sy_id' => '1',
        ]);
        $class = Classes::create([
            'student_subject_id' => '2',
            'faculty_id' => '4',
            'sy_id' => '1',
        ]);
    }
}
