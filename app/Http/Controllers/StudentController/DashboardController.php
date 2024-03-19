<?php

namespace App\Http\Controllers\StudentController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\StudentSubjects;
use App\Models\StudentUser;
use App\Models\ClassAdvisory;
class DashboardController extends Controller
{
    public function index(){
        $role = auth()->user()->role;
        $user_id = auth()->user()->id;
        // $student = StudentUser::where('id',$user_id)->first();
        // $faculty_id = ClassAdvisory::where('glevel_section_id', $student->glevel_section_id)->first();
        $students = StudentUser::select('*','student_personal_details.id as sid' ,'student_personal_details.firstname AS sfname', 'student_personal_details.lastname AS slname', 'student_personal_details.gender AS sgender')->join('student_subject', 'student_subject.student_id', '=', 'student_personal_details.id')->join('subject', 'subject.id', '=', 'student_subject.subject_id')->leftJoin('class', 'class.subject_id', '=', 'subject.id')->leftJoin('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->leftJoin('grades_per_subject', 'grades_per_subject.student_subject_id', '=', 'student_subject.id')->join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->where('student_user_mapping.user_id', $user_id)->get();
        
        foreach($students as $student){
            $ctr = 0;
        $stud_subj = StudentSubjects::where('student_id', $student->sid)->get();
        foreach($stud_subj as $temp){
            $ctr += Grade::where('student_subject_id', $temp->id)->where('firstQ', '<', 80)->count();
            $ctr += Grade::where('student_subject_id', $temp->id)->where('secondQ', '<', 80)->count();
            $ctr += Grade::where('student_subject_id', $temp->id)->where('thirdQ', '<', 80)->count();
            $ctr += Grade::where('student_subject_id', $temp->id)->where('fourthQ', '<', 80)->count();
        }
    }
        return view('student.dashboard', compact('ctr'));
    }
}
