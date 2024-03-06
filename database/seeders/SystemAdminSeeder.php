<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\FacultyStaff;
use App\Models\FacultyStaffUserMapping;

class SystemAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::create([
            'username' => 'nelsontejara',
            'password' => Hash::make('vsuihshrrs'),
            'email' => 'nelsontejara@gmail.com',
            'role' => '1',
            'sy_id' => '1',
            'avatar' => 'admin-male.png',
            
        ]);
        $faculty_staff_details = FacultyStaff::create([
            'university_number' => '123786128934',
            'firstname' => 'Nelson',
            'middlename' => 'Tejara',
            'lastname' => 'Tejara',
            'gender' => 'Male',
            'phone_number' => '639123456789',
            'home_address' => 'Baybay City, Leyte', 
        ]);
        $faculty_staff_user_mapping = FacultyStaffUserMapping::create([
            'faculty_staff_id' => $faculty_staff_details->id,
            'user_id' => $users->id,
        ]);
        $users = User::create([
            'username' => 'darylpiamonte',
            'password' => Hash::make('piamonte'),
            'email' => 'darylpiamonte@gmail.com',
            'role' => '2',
            'sy_id' => '1',
            'avatar' => 'admin-male.png',
            
        ]);
        $faculty_staff_details = FacultyStaff::create([
            'university_number' => '123786128957',
            'firstname' => 'Daryl',
            'middlename' => 'Acampado',
            'lastname' => 'Piamonte',
            'gender' => 'Male',
            'phone_number' => '639617053870',
            'home_address' => 'Baybay City, Leyte', 
        ]);
        $faculty_staff_user_mapping = FacultyStaffUserMapping::create([
            'faculty_staff_id' => $faculty_staff_details->id,
            'user_id' => $users->id,
        ]);
    }
}
