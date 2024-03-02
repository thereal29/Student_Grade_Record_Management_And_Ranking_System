<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\FacultyStaff;
use App\Models\FacultyStaffUserMapping;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::create([
            'username' => 'judebrola',
            'password' => Hash::make('juderola'),
            'email' => 'judebrola@gmail.com',
            'role' => '5',
            'sy_id' => '1',
            'avatar' => 'faculty-male.png',
            
        ]);
        $faculty_staff_details = FacultyStaff::create([
            'university_number' => '123786120099',
            'firstname' => 'Jude',
            'middlename' => 'Bulawan',
            'lastname' => 'Rola',
            'gender' => 'Male',
            'phone_number' => '09123456789',
            'home_address' => 'Baybay City, Leyte', 
        ]);
        $faculty_staff_user_mapping = FacultyStaffUserMapping::create([
            'faculty_staff_id' => $faculty_staff_details->id,
            'user_id' => $users->id,
        ]);

        $users = User::create([
            'username' => 'jonamaaghop',
            'password' => Hash::make('maaghops'),
            'email' => 'jonamaaghop@gmail.com',
            'role' => '5',
            'sy_id' => '1',
            'avatar' => 'faculty-female.png',
            
        ]);
        $faculty_staff_details = FacultyStaff::create([
            'university_number' => '123786128999',
            'firstname' => 'Jona',
            'middlename' => 'Orano',
            'lastname' => 'Maaghop',
            'gender' => 'Female',
            'phone_number' => '09123459789',
            'home_address' => 'Baybay City, Leyte', 
        ]);
        $faculty_staff_user_mapping = FacultyStaffUserMapping::create([
            'faculty_staff_id' => $faculty_staff_details->id,
            'user_id' => $users->id,
        ]);
        
    }
}
