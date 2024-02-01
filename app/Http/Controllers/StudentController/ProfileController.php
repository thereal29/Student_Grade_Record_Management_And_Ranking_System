<?php

namespace App\Http\Controllers\StudentController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(){
        $user_id = auth()->user()->id;
        $details = DB::table('student_personal_details')->join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->where('users.id', $user_id)->first();
        return view('student.profile.index', compact('details', 'user_id'));
    }
}
