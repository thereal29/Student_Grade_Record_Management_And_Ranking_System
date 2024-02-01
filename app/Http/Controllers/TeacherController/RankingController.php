<?php

namespace App\Http\Controllers\TeacherController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolYear;
use App\Models\ClassAdvisory;

class RankingController extends Controller
{
    public function index(){
        $user_id = auth()->user()->id;
        $currSY = SchoolYear::select('*')->where('isCurrent', '=', 1)->first();
        $advisories = ClassAdvisory::select('*','class_advisory.id as caid', 'student_gradelevel_section.grade_level as glevel')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class_advisory.faculty_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'class_advisory.glevel_section_id')->join('school_year', 'school_year.id', '=', 'class_advisory.sy_id')->where('class_advisory.faculty_id', $user_id)->get();
        return view('teacher.modules.honor_roll.index', compact('advisories'));
    }
}
