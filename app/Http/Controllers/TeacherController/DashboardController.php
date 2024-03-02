<?php

namespace App\Http\Controllers\TeacherController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\SchoolYear;
use App\Models\StudentUser;
use App\Models\Classes;
class DashboardController extends Controller
{
    public function index(Request $request){
        $user_id = auth()->user()->id;
        $SY = request()->post('schoolyear');
        $currSY = SchoolYear::select('*')->where('from_year', $SY)->first();
        if($currSY != null){
            \Session::put('fromSY', $currSY->from_year);
            \Session::put('toSY', $currSY->to_year);
        }
        $selSY = \Session::get('fromSY');
        $students = StudentUser::select('*')->join('class_advisory', 'class_advisory.glevel_section_id', '=', 'student_personal_details.glevel_section_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class_advisory.faculty_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->join('school_year', 'school_year.id', '=', 'class_advisory.sy_id')->where('class_advisory.faculty_id', $user_id)->where('school_year.from_year', $selSY)->get();
        $subjects = Classes::select('*')->join('student_subject', 'student_subject.id', '=', 'class.student_subject_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->join('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->join('school_year', 'school_year.id', '=', 'class.sy_id')->where('class.faculty_id', $user_id)->where('school_year.from_year', $selSY)->get();
        $studentCTR = $students->count();
        $subjectCTR = $subjects->count();
        return view('faculty.dashboard', compact('studentCTR','subjectCTR'));
    }
}
