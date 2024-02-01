<?php

namespace App\Http\Controllers\TeacherController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentUser;
use App\Models\SchoolYear;
use App\Models\ClassAdvisory;

class AdvisoryController extends Controller
{
    public function index(){
        $user_id = auth()->user()->id;
        $selSY = \Session::get('fromSY');
        $students = StudentUser::select('*', 'student_personal_details.firstname AS sfname', 'student_personal_details.lastname AS slname', 'student_personal_details.gender AS sgender','student_gradelevel_section.grade_level as glevel')->join('class_advisory', 'class_advisory.glevel_section_id', '=', 'student_personal_details.glevel_section_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class_advisory.faculty_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->join('school_year', 'school_year.id', '=', 'class_advisory.sy_id')->where('class_advisory.faculty_id', $user_id)->where('school_year.from_year', $selSY)->get();
        $advisory = ClassAdvisory::join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'class_advisory.glevel_section_id')->join('school_year', 'school_year.id', '=', 'class_advisory.sy_id')->where('class_advisory.faculty_id', $user_id)->where('school_year.from_year', $selSY)->first();
        return view('teacher.modules.advisory.index', compact('students', 'advisory'));
    }
}
