<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            'description' => 'Super Administrator',
        ]);
        DB::table('user_roles')->insert([
            'description' => 'Administrator',
        ]);
        DB::table('user_roles')->insert([
            'description' => 'Honors and Awards Committee',
        ]);
        DB::table('user_roles')->insert([
            'description' => 'Guidance Facilitator',
        ]);
        DB::table('user_roles')->insert([
            'description' => 'Faculty',
        ]);
        DB::table('user_roles')->insert([
            'description' => 'Junior High School Student',
        ]);
        DB::table('user_roles')->insert([
            'description' => 'Senior High School Student',
        ]);
    }
}
