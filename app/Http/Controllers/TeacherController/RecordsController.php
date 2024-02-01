<?php

namespace App\Http\Controllers\TeacherController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentUser;
use App\Models\ClassAdvisory;
use App\Models\SchoolYear;

class RecordsController extends Controller
{
    public function index(){
        $user_id = auth()->user()->id;
        $selSY = \Session::get('fromSY');
        $student = StudentUser::select('*', 'student_personal_details.firstname AS sfname', 'student_personal_details.lastname AS slname', 'student_personal_details.gender AS sgender','student_gradelevel_section.grade_level as glevel')->join('class_advisory', 'class_advisory.glevel_section_id', '=', 'student_personal_details.glevel_section_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class_advisory.faculty_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->join('school_year', 'school_year.id', '=', 'class_advisory.sy_id')->where('class_advisory.faculty_id', $user_id)->where('school_year.from_year', $selSY)->get();
        return view('teacher.modules.student_records.index', compact('student'));
    }
    public function viewRec(Request $request){
        $user_id = auth()->user()->id;
        $records = StudentUser::select('*','student_personal_details.firstname AS fnameStud', 'student_personal_details.middlename AS mnameStud', 'student_personal_details.lastname AS lnameStud', 'subject.grade_level as sgrade_level')->join('grades_per_subject', 'grades_per_subject.student_id', '=', 'student_personal_details.id')->join('subject', 'subject.id', '=', 'grades_per_subject.subject_id')->join('student_advisory', 'student_advisory.student_id', '=', 'student_personal_details.id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'student_advisory.adviser_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->where('student_personal_details.id', $request->id)->where('student_advisory.adviser_id', $user_id)->get();
        $student = StudentUser::select('*', 'student_personal_details.firstname AS sfname', 'student_personal_details.middlename AS smname', 'student_personal_details.lastname AS slname', 'student_gradelevel_section.grade_level as sgrade_level', 'student_personal_details.gender AS sgender')->join('student_subject', 'student_subject.student_id', '=', 'student_personal_details.id')->join('class', 'class.id', '=', 'student_subject.class_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->join('subject', 'subject.id', '=', 'class.subject_id')->join('grades_per_subject', 'grades_per_subject.student_id', '=', 'student_personal_details.id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->where('student_personal_details.id', $request->id)->first();
        foreach($records as $record){
        $final_rating = ($record->firstQ + $record->secondQ + $record->thirdQ + $record->fourthQ)/4 ;
        }
        return view('teacher.modules.student_records.view_record', compact('records', 'student', 'final_rating'));
    }
    public function viewStuData(Request $request){
        $details = StudentUser::join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->where('student_personal_details.id', $request->id)->first();
        return view('teacher.modules.student_records.view_personal_data', compact('details'));
    }
}
