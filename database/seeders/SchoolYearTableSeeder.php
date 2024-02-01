<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolYearTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('school_year')->insert([
            'from_year' => 2021,
            'to_year' => 2022,
            'quarter' => '1st Quarter',
            'isCurrent' => 0,
        ]);
        DB::table('school_year')->insert([
            'from_year' => 2021,
            'to_year' => 2022,
            'quarter' => '2nd Quarter',
            'isCurrent' => 0,
        ]);
        DB::table('school_year')->insert([
            'from_year' => 2021,
            'to_year' => 2022,
            'quarter' => '3rd Quarter',
            'isCurrent' => 0,
        ]);
        DB::table('school_year')->insert([
            'from_year' => 2021,
            'to_year' => 2022,
            'quarter' => '4th Quarter',
            'isCurrent' => 0,
        ]);
        DB::table('school_year')->insert([
            'from_year' => 2022,
            'to_year' => 2023,
            'quarter' => '1st Quarter',
            'isCurrent' => 0,
        ]);
        DB::table('school_year')->insert([
            'from_year' => 2022,
            'to_year' => 2023,
            'quarter' => '2nd Quarter',
            'isCurrent' => 0,
        ]);
        DB::table('school_year')->insert([
            'from_year' => 2022,
            'to_year' => 2023,
            'quarter' => '3rd Quarter',
            'isCurrent' => 0,
        ]);
        DB::table('school_year')->insert([
            'from_year' => 2022,
            'to_year' => 2023,
            'quarter' => '4th Quarter',
            'isCurrent' => 0,
        ]);
        DB::table('school_year')->insert([
            'from_year' => 2023,
            'to_year' => 2024,
            'quarter' => '1st Quarter',
            'isCurrent' => 1,
        ]);
        DB::table('school_year')->insert([
            'from_year' => 2023,
            'to_year' => 2024,
            'quarter' => '2nd Quarter',
            'isCurrent' => 0,
        ]);
        DB::table('school_year')->insert([
            'from_year' => 2023,
            'to_year' => 2024,
            'quarter' => '3rd Quarter',
            'isCurrent' => 0,
        ]);
        DB::table('school_year')->insert([
            'from_year' => 2023,
            'to_year' => 2024,
            'quarter' => '4th Quarter',
            'isCurrent' => 0,
        ]);
    }
}
