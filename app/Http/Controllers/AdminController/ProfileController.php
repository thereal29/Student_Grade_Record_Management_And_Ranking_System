<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\FacultyStaff;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $details = FacultyStaff::join('faculty_staff_user_mapping', 'faculty_staff_user_mapping.faculty_staff_id', '=', 'faculty_staff_personal_details.id')->join('users', 'users.id', '=', 'faculty_staff_user_mapping.user_id')->where('users.id', $user_id)->first();
        return view('admin.profile', compact('details'));
    }
}
