<?php

namespace App\Http\Controllers\TeacherController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FacultyStaff;

class ProfileController extends Controller
{
    public function index(){
        $user_id = auth()->user()->id;
        $details = FacultyStaff::join('faculty_staff_user_mapping', 'faculty_staff_user_mapping.faculty_staff_id', '=', 'faculty_staff_personal_details.id')->join('users', 'users.id', '=', 'faculty_staff_user_mapping.user_id')->where('users.id', $user_id)->first();
        return view('teacher.profile', compact('details', 'user_id'));
    }
}
