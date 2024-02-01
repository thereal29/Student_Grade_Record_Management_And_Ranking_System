<?php

namespace App\Http\Controllers\StudentController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentUser;

class GradesController extends Controller
{
    public function index(){
        $user_id = auth()->user()->id;
        $details = StudentUser::join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->where('users.id', $user_id)->first();
        $currGrade = $details->grade_level;
        return view('student.grade.index', compact('currGrade'));
    }
    public function fetchGrades(Request $request){
        $user_id = auth()->user()->id;
        if($request->gradelevel != null && $request->gradelevel != 'showall'){
            $students = StudentUser::select('*', 'student_personal_details.firstname AS sfname', 'student_personal_details.lastname AS slname', 'student_personal_details.gender AS sgender')->join('student_subject', 'student_subject.student_id', '=', 'student_personal_details.id')->join('class', 'class.student_subject_id', '=', 'student_subject.subject_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->join('subject', 'subject.id', '=', 'student_subject.subject_id')->join('grades_per_subject', 'grades_per_subject.student_subject_id', '=', 'student_subject.id')->join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->where('student_user_mapping.user_id', $user_id)->where('student_gradelevel_section.grade_level', $request->gradelevel)->get();
        }else{
            $students = StudentUser::select('*', 'student_personal_details.firstname AS sfname', 'student_personal_details.lastname AS slname', 'student_personal_details.gender AS sgender')->join('student_subject', 'student_subject.student_id', '=', 'student_personal_details.id')->join('class', 'class.student_subject_id', '=', 'student_subject.subject_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->join('subject', 'subject.id', '=', 'student_subject.subject_id')->join('grades_per_subject', 'grades_per_subject.student_id', '=', 'student_personal_details.id')->join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->where('student_user_mapping.user_id', $user_id)->get();
        }
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
            'query'=> $query
        ]);
    }
}
