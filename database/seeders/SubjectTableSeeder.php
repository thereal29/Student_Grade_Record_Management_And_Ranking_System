<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subject')->insert([
            'subject_code' => 'English I',
            'subject_description' => 'Eng. Gram. & Comp. & Phil. Lit.',
            'credits' => '1.5',
            'grade_level' => 'Grade 7',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Filipino I',
            'subject_description' => 'Fil. Gram., Comp. & Lit.',
            'credits' => '1.5',
            'grade_level' => 'Grade 7',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Math IA',
            'subject_description' => 'Applied Math',
            'credits' => '1.0',
            'grade_level' => 'Grade 7',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Math IB',
            'subject_description' => 'Elementary Algebra',
            'credits' => '1.0',
            'grade_level' => 'Grade 7',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Science I',
            'subject_description' => 'Earth Science',
            'credits' => '1.5',
            'grade_level' => 'Grade 7',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Computer I',
            'subject_description' => 'Basic Computer Education',
            'credits' => '1.0',
            'grade_level' => 'Grade 7',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'THE I',
            'subject_description' => 'Agriculture',
            'credits' => '0.6',
            'grade_level' => 'Grade 7',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'THE I',
            'subject_description' => 'Home Science',
            'credits' => '0.6',
            'grade_level' => 'Grade 7',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Soc. Stud. I',
            'subject_description' => 'Phil. Hist. & Govt., Const. & C. E.',
            'credits' => '1.2',
            'grade_level' => 'Grade 7',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'PEHM I',
            'subject_description' => 'P.E., Health & Music',
            'credits' => '1.2',
            'grade_level' => 'Grade 7',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Values Education I',
            'subject_description' => 'Human Beings as Creatures',
            'credits' => '0.4',
            'grade_level' => 'Grade 7',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'English II',
            'subject_description' => 'Eng. Gram. & Comp. & Afro-Asian Lit.',
            'credits' => '1.5',
            'grade_level' => 'Grade 8',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Filipino II',
            'subject_description' => 'Fil. Gram., Comp. & Lit',
            'credits' => '1.5',
            'grade_level' => 'Grade 8',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Math IIA',
            'subject_description' => 'Plane & Solid Geometry',
            'credits' => '1.0',
            'grade_level' => 'Grade 8',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Math IIB',
            'subject_description' => 'Advanced Algebra',
            'credits' => '1.0',
            'grade_level' => 'Grade 8',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Science II',
            'subject_description' => 'Biology I',
            'credits' => '1.5',
            'grade_level' => 'Grade 8',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Statistics I',
            'subject_description' => 'Introduction to Statistics',
            'credits' => '1.0',
            'grade_level' => 'Grade 8',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'THE II',
            'subject_description' => 'Agriculture',
            'credits' => '0.6',
            'grade_level' => 'Grade 8',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'THE II',
            'subject_description' => 'Home Science',
            'credits' => '0.6',
            'grade_level' => 'Grade 8',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Soc. Stud. II',
            'subject_description' => 'Hist. of Asian Nations & C.E.',
            'credits' => '1.2',
            'grade_level' => 'Grade 8',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'PEHM II',
            'subject_description' => 'P.E., Health & Music',
            'credits' => '1.2',
            'grade_level' => 'Grade 8',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Values Education II',
            'subject_description' => 'Persons as Social Beings',
            'credits' => '0.4',
            'grade_level' => 'Grade 8',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'English III',
            'subject_description' => 'Eng. Gram. & Comp. & Eng. Amer. Lit.',
            'credits' => '1.5',
            'grade_level' => 'Grade 9',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Filipino III',
            'subject_description' => 'Fil. Gram., Comp. & Lit.',
            'credits' => '1.5',
            'grade_level' => 'Grade 9',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Math III',
            'subject_description' => 'Trigonometry',
            'credits' => '1.0',
            'grade_level' => 'Grade 9',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Science IIIA',
            'subject_description' => 'General Chemistry',
            'credits' => '1.5',
            'grade_level' => 'Grade 9',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Science IIIB',
            'subject_description' => 'Biology II',
            'credits' => '1.0',
            'grade_level' => 'Grade 9',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Computer II',
            'subject_description' => 'Introduction to Statistical Computing',
            'credits' => '1.0',
            'grade_level' => 'Grade 9',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Research I',
            'subject_description' => 'Research Methods and Design',
            'credits' => '0.8',
            'grade_level' => 'Grade 9',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'THE III',
            'subject_description' => 'Agriculture',
            'credits' => '0.6',
            'grade_level' => 'Grade 9',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'THE III',
            'subject_description' => 'Home Science',
            'credits' => '0.6',
            'grade_level' => 'Grade 9',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Soc. Stud. III',
            'subject_description' => 'World Hist. & Current Events',
            'credits' => '1.2',
            'grade_level' => 'Grade 9',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'PEHMA III',
            'subject_description' => 'P.E., Health, Music, and Arts',
            'credits' => '1.2',
            'grade_level' => 'Grade 9',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Values Education III',
            'subject_description' => 'Person, Work and Country',
            'credits' => '0.4',
            'grade_level' => 'Grade 9',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'English IV',
            'subject_description' => 'Eng. Gram. & Comp. World Lit',
            'credits' => '1.5',
            'grade_level' => 'Grade 10',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Filipino IV',
            'subject_description' => 'Fil. Gram., Comp. & Lit.',
            'credits' => '1.5',
            'grade_level' => 'Grade 10',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Math IV',
            'subject_description' => 'Analytic Geometry with Basic Calculus',
            'credits' => '1.5',
            'grade_level' => 'Grade 10',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Science IVA',
            'subject_description' => 'Physics',
            'credits' => '1.5',
            'grade_level' => 'Grade 10',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Science IVB',
            'subject_description' => 'Organic Chemistry and Biochemistry',
            'credits' => '1.0',
            'grade_level' => 'Grade 10',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Research II',
            'subject_description' => 'Res. Implem., Analysis & Documen.',
            'credits' => '1.0',
            'grade_level' => 'Grade 10',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'THE IV',
            'subject_description' => 'Agriculture',
            'credits' => '0.6',
            'grade_level' => 'Grade 10',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'THE IV',
            'subject_description' => 'Home Science',
            'credits' => '0.6',
            'grade_level' => 'Grade 10',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Soc. Stud. IV',
            'subject_description' => 'Economics & Current Events',
            'credits' => '1.2',
            'grade_level' => 'Grade 10',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'CAT-I',
            'subject_description' => 'Citizens Army Training',
            'credits' => '1.2',
            'grade_level' => 'Grade 10',
        ]);
        DB::table('subject')->insert([
            'subject_code' => 'Values Education IV',
            'subject_description' => 'Human Beings as Moral Persons',
            'credits' => '0.4',
            'grade_level' => 'Grade 10',
        ]);
    }
}
