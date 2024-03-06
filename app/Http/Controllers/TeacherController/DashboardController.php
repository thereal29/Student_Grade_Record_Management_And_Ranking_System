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
        $currSelSY = SchoolYear::select('*')->where('from_year', $SY)->first();
        $currSY = SchoolYear::select('*')->where('isCurrent', 1)->first();
        if($currSelSY != null){
            \Session::put('fromSY', $currSelSY->from_year);
            \Session::put('toSY', $currSelSY->to_year);
            \Session::put('quarter', $currSelSY->to_year);
        }
        $selSY = \Session::get('fromSY');
        $selSY2 = \Session::get('toSY');
        $student_selSY = StudentUser::select('*')->join('class_advisory', 'class_advisory.glevel_section_id', '=', 'student_personal_details.glevel_section_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class_advisory.faculty_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->join('school_year', 'school_year.id', '=', 'class_advisory.sy_id')->where('class_advisory.faculty_id', $user_id)->where('school_year.from_year', $selSY)->get();
        $student_currSY = StudentUser::select('*')->join('class_advisory', 'class_advisory.glevel_section_id', '=', 'student_personal_details.glevel_section_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class_advisory.faculty_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->join('school_year', 'school_year.id', '=', 'class_advisory.sy_id')->where('class_advisory.faculty_id', $user_id)->where('school_year.from_year', $currSY->from_year)->get();
        $class_selSY = Classes::select('*')->join('subject', 'subject.id', '=', 'class.subject_id')->join('student_subject', 'student_subject.subject_id', '=', 'subject.id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->join('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->join('school_year', 'school_year.id', '=', 'class.sy_id')->where('class.faculty_id', $user_id)->where('school_year.from_year', $selSY)->get();
        $class_currSY = Classes::select('*')->join('subject', 'subject.id', '=', 'class.subject_id')->join('student_subject', 'student_subject.subject_id', '=', 'subject.id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->join('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->join('school_year', 'school_year.id', '=', 'class.sy_id')->where('class.faculty_id', $user_id)->where('school_year.from_year', $currSY->from_year)->get();
        $studentCTR_selSY = $student_selSY->count();
        $studentCTR_currSY = $student_currSY->count();
        $classCTR_selSY = $class_selSY->count();
        $classCTR_currSY = $class_currSY->count();
        return view('faculty.dashboard', compact('studentCTR_selSY','classCTR_selSY', 'studentCTR_currSY','classCTR_currSY', 'selSY','selSY2','currSY'));
    }
}
