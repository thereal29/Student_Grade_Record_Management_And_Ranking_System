<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\StudentUser;
use App\Models\StudentUserMapping;
use App\Models\StudentAdvisory;
class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::create([
            'username' => 'francis',
            'password' => Hash::make('batohinog'),
            'email' => 'francis@gmail.com',
            'role' => '6',
            'sy_id' => '1',
            'avatar' => 'default-male.png',
        ]);
        $student_personal_details = StudentUser::create([
            'firstname' => 'Francis A-J',
            'middlename' => '',
            'lastname' => 'Batohinog',
            'lrn_number' => '123456789126',
            'gender' => 'Male',
            'age' => '21',
            'glevel_section_id' => '4',
            'birth_date' => '2003-1-12',
            'home_address' => 'Brgy. Punong, Bato, Leyte',
            'phone_number' => '09123456789',
            'parent_name' => 'Unknown',
            'parent_address' => 'Brgy. Guadalupe, Baybay City, Leyte',
            'previous_school_graduated' => 'San Juan National High School',
            'year_graduated' => '2016',
            'previous_school_average' => '99.00',
            
        ]);
        $student_user_mapping = StudentUserMapping::create([
            'student_id' => $student_personal_details->id,
            'user_id' => $users->id,
        ]);
        $student_advisory = StudentAdvisory::create([
            'student_id' => $student_personal_details->id,
            'adviser_id' => '3',
        ]);

        $users = User::create([
            'username' => 'neil',
            'password' => Hash::make('lagaretneil'),
            'email' => 'neil@gmail.com',
            'role' => '7',
            'sy_id' => '1',
            'avatar' => 'default-male.png',
        ]);
        $student_personal_details = StudentUser::create([
            'firstname' => 'Neil Wayne',
            'middlename' => '',
            'lastname' => 'Lagaret',
            'lrn_number' => '123456789129',
            'gender' => 'Male',
            'age' => '20',
            'glevel_section_id' => '6',
            'birth_date' => '2003-1-12',
            'home_address' => 'Brgy. Punong, Bato, Leyte',
            'phone_number' => '09123456789',
            'parent_name' => 'Unknown',
            'parent_address' => 'Brgy. Guadalupe, Baybay City, Leyte',
            'previous_school_graduated' => 'San Juan National High School',
            'year_graduated' => '2016',
            'previous_school_average' => '99.00',
            
        ]);
        $student_user_mapping = StudentUserMapping::create([
            'student_id' => $student_personal_details->id,
            'user_id' => $users->id,
        ]);
        $student_advisory = StudentAdvisory::create([
            'student_id' => $student_personal_details->id,
            'adviser_id' => '3',
        ]);
        
    }
}