<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Grade;
use App\Models\Subjects;
use App\Models\StudentSubjects;

class GradePerSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subject = Subjects::create([
            'subject_code' => 'English I',
            'subject_description' => 'Eng. Gram. & Comp. & Phil. Lit.',
            'credits' => '1.50',
            'grade_level' => 'Grade 7',
        ]);
        $subject = Subjects::create([
            'subject_code' => 'Math IA',
            'subject_description' => 'Applied Math',
            'credits' => '1',
            'grade_level' => 'Grade 7',
        ]);
        $subject = Subjects::create([
            'subject_code' => 'English II',
            'subject_description' => 'Eng. Gram. & Comp. & Afro-Asian Lit.',
            'credits' => '1.50',
            'grade_level' => 'Grade 8',
        ]);
        $subject = Subjects::create([
            'subject_code' => 'Math IIA',
            'subject_description' => 'Plane & Solid Geometry',
            'credits' => '1.50',
            'grade_level' => 'Grade 8',
        ]);
        $subject = Subjects::create([
            'subject_code' => 'English III',
            'subject_description' => 'Eng. Gram. & Comp. & Eng. Amer. Lit.',
            'credits' => '1.50',
            'grade_level' => 'Grade 9',
        ]);
        $subject = Subjects::create([
            'subject_code' => 'Math III',
            'subject_description' => 'Trigonometry',
            'credits' => '1.50',
            'grade_level' => 'Grade 9',
        ]);
        $subject = Subjects::create([
            'subject_code' => 'English IV',
            'subject_description' => 'Eng. Gram. & Comp. & World Lit.',
            'credits' => '1.50',
            'grade_level' => 'Grade 10',
        ]);
        $subject = Subjects::create([
            'subject_code' => 'Math IV',
            'subject_description' => 'Analytic Geometry with Basic Calculus',
            'credits' => '1.50',
            'grade_level' => 'Grade 10',
        ]);
        $subject = Subjects::create([
            'subject_code' => 'OralCom I',
            'subject_description' => 'Oral Communication',
            'credits' => '1.50',
            'grade_level' => 'Grade 11',
        ]);
        $subject = Subjects::create([
            'subject_code' => 'Calc I',
            'subject_description' => 'Pre-Calculus',
            'credits' => '1.50',
            'grade_level' => 'Grade 11',
        ]);
        $subject = Subjects::create([
            'subject_code' => 'OralCom II',
            'subject_description' => 'Purposive Communication',
            'credits' => '1.50',
            'grade_level' => 'Grade 12',
        ]);
        $subject = Subjects::create([
            'subject_code' => 'Calc II',
            'subject_description' => 'Differential Calculus',
            'credits' => '1.50',
            'grade_level' => 'Grade 12',
        ]);

        $student_subject = StudentSubjects::create([
            'subject_id' => '1',
            'student_id' => '1',
            'sy_id' => '1',
            'status' => 'Added',
        ]);
        
        
        $student_subject = StudentSubjects::create([
            'subject_id' => '3',
            'student_id' => '2',
            'sy_id' => '1',
            'status' => 'Added',
        ]);
        $grade = Grade::create([
            'student_subject_id' => '1',
            'firstQ' => '90',
            'secondQ' => '90',
            'thirdQ' => '90',
            'fourthQ' => '90',
        ]);


    }
}
