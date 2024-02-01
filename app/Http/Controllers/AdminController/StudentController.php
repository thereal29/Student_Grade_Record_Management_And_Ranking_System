<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentUser;
use App\Models\Classes;
// use App\Models\Curriculum;
// use App\Models\CurriculumGrades;
use Illuminate\Support\Facades\DB;
class StudentController extends Controller
{
    public function index(){
        $selSY = \Session::get('fromSY');
        $students = StudentUser::select('*','student_personal_details.id as sid')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->join('school_year', 'school_year.id', '=', 'users.sy_id')->where('school_year.from_year', $selSY)->get();
        return view('admin.modules.students.index', compact('students'));
    }
    public function viewProfile(Request $request){
        $details = StudentUser::select('*', 'student_personal_details.id as sid', 'faculty_staff_personal_details.firstname as ffname', 'faculty_staff_personal_details.lastname as flname')->join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->leftJoin('student_advisory', 'student_advisory.student_id', '=', 'student_personal_details.id')->leftJoin('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'student_advisory.adviser_id')->where('student_personal_details.id', $request->id)->first();
        $classes = Classes::join('student_subject', 'student_subject.id', '=', 'class.student_subject_id')->where('student_subject.student_id', $details->sid)->get();
        $numClass = $classes->count();
        return view('admin.modules.students.profile', compact('details', 'numClass'));
    }
    public function viewRecord(Request $request){
        $record = StudentUser::select('*','student_personal_details.id AS studID','student_personal_details.firstname AS fnameStud', 'student_personal_details.middlename AS mnameStud', 'student_personal_details.lastname AS lnameStud', 'subject.grade_level as sgrade_level')->leftJoin('student_subject', 'student_subject.student_id', '=', 'student_personal_details.id')->leftJoin('grades_per_subject', 'grades_per_subject.student_subject_id', '=', 'student_subject.id')->leftJoin('subject', 'subject.id', '=', 'student_subject.subject_id')->join('student_advisory', 'student_advisory.student_id', '=', 'student_personal_details.id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'student_advisory.adviser_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->where('student_personal_details.id', $request->id)->first();
        return view('admin.modules.student_record.view_record', compact('record'));
    }
    public function fetchRecord(Request $request){
        $gradelevel = $request->gradelevel;
        $studID = $request->student_id;
        $students = StudentUser::select('*', 'student_personal_details.firstname AS sfname', 'student_personal_details.lastname AS slname', 'student_personal_details.gender AS sgender')->leftJoin('student_subject', 'student_subject.student_id', '=', 'student_personal_details.id')->leftJoin('class', 'class.student_subject_id', '=', 'student_subject.id')->leftJoin('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->leftJoin('subject', 'subject.id', '=', 'student_subject.subject_id')->leftJoin('grades_per_subject', 'grades_per_subject.student_subject_id', '=', 'student_subject.id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->where('student_personal_details.id', $studID)->where('student_gradelevel_section.grade_level', $gradelevel)->groupBy('student_subject.student_id')->get();
        foreach($students as $student){
            $final_rating = ($student->firstQ + $student->secondQ + $student->thirdQ + $student->fourthQ)/4 ;
        }
        $query = '';
        if($students->count() > 0){
            $query .= '<table  class="table table-striped" cellspacing="0" id="table">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="4" style="font-size:14px; font-weight:bold; text-align:center;">Quarter</th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <th style="font-size:14px; font-weight:bold; text-align:center;">Subject</th>
                    <th style="font-size:14px; font-weight:bold; text-align:center;">Credits</th>
                    <th style="font-size:14px; font-weight:bold; text-align:center;">Instructor</th>
                    <th style="font-size:14px; font-weight:bold; text-align:center;">1st</th>
                    <th style="font-size:14px; font-weight:bold; text-align:center;">2nd</th>
                    <th style="font-size:14px; font-weight:bold; text-align:center;">3rd</th>
                    <th style="font-size:14px; font-weight:bold; text-align:center;">4th</th>
                    <th style="font-size:14px; font-weight:bold; text-align:center;">Final</th>				  		
                    <th style="font-size:14px; font-weight:bold; text-align:center;">Remarks</th>
                </tr>
            </thead>
            <tbody>';
            foreach($students as $student){
                $query .= '<tr>
                            <td>'. $student->subject_code .'&nbsp | &nbsp'. $student->subject_description .'</td>
                            <td style="width: 6%; text-align:center;">'. $student->credits .'</td>
                            <td style="width: 20%; text-align:center;">'. $student->firstname.' '. $student->lastname .'</td>
                            <td style="width: 6%; text-align:center;">'. $student->firstQ .'</td>
                            <td style="width: 6%; text-align:center;">'. $student->secondQ .'</td>
                            <td style="width: 6%; text-align:center;">'. $student->thirdQ .'</td>
                            <td style="width: 6%; text-align:center;">'. $student->fourthQ .'</td>
                            <td style="width: 6%; text-align:center; font-weight:bold; color:blue; background-color: #FFFBC8;">'. $final_rating .'</td>';
                            if($final_rating < 75){
                            $query .= '<td style="width: 5%; text-align:center; font-weight:bold; color:red; background-color: #D6EEEE;">FAILED</td>';
                            }else{
                            $query .= '<td style="width: 5%; text-align:center; font-weight:bold; color:green; background-color: #D6EEEE;">PASSED</td>';
                            }
                $query .= '</tr>';
            }
            $query .= '</tbody></table>';
        }else{
            $query = '<h5 class="text-center text-secondary my-4">No data found</h5>';
        }
        return response()->json([
            'status'=>'success',
            'query'=> $query,
            'id' =>$studID,
            'a' => $students
        ]);
    }
}
