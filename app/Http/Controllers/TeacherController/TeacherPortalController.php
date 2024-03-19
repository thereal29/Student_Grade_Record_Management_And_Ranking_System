<?php

namespace App\Http\Controllers\TeacherController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FacultyStaff;
use App\Models\ClassAdvisory;
use App\Models\StudentUser;
use App\Models\Classes;
use App\Models\SchoolYear;
use App\Models\Grade;
use App\Models\StudentSubjects;

use Illuminate\Support\Facades\DB;

class TeacherPortalController extends Controller
{
    public function maincontent(){
        $user_id = auth()->user()->id;
        $details = FacultyStaff::join('faculty_staff_user_mapping', 'faculty_staff_user_mapping.faculty_staff_id', '=', 'faculty_staff_personal_details.id')->join('users', 'users.id', '=', 'faculty_staff_user_mapping.user_id')->where('users.id', $user_id)->first();
        return view('faculty.portal', compact('details', 'user_id'));
    }
    public function fetchClass(Request $request){
        $user_id = auth()->user()->id;
        $classes = Classes::select('*', 'class.id as cid','subject.grade_level AS class_glevel', DB::raw('COUNT(student_personal_details.id) AS ctr'))->join('subject', 'subject.id', '=', 'class.subject_id')->leftJoin('student_subject', 'student_subject.subject_id', '=', 'subject.id')->leftJoin('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->join('school_year', 'school_year.id', '=', 'class.sy_id')->where('class.faculty_id', $user_id)->groupBy('class.subject_id')->get();
        $query = '<table class="table border-0 star-student table-hover table-center mb-0 datatables table-striped">
            <thead class="student-thread">
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Description</th>
                    <th>Grade Level</th>
                    <th>Credits</th>
                    <th>No. of Students</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>';
            foreach($classes as $class){
                $query .= '<tr>
                <td>'.$class->subject_code.'</td>
                <td>'.$class->subject_description.'</td>
                <td>'.$class->grade_level.'</td>
                <td>'.$class->credits.'</td>
                <td><div class="badge badge-info" style="font-size:14px;">'.$class->ctr;
                if($class->ctr > 1){
                    $query .= ' Students';
                }else{
                    $query .= ' Student';
                }
                $query .= '</div></td>
                <td>
                    <button id="'.$class->cid.'" class="btn btn-sm bg-danger-light view_class d-flex">
                        <div class="badge badge-warning" style="font-size:14px;">
                            <i class="fas fa-eye"></i> View This Class
                        </div>
                    </button>
                    <a href="'. route("class.pdf", ['id' => $class->cid]) .'" target="_blank" id="'.$class->cid.'" class="btn btn-sm bg-danger-light print_class d-flex">
                    <div class="badge badge-danger" style="font-size:14px;">
                        <i class="fas fa-print"></i> Print Class Roster
                    </div>
                    </a>
                    <a href="'. route("class.excel", ['id' => $class->cid]) .'" target="_blank" id="'.$class->cid.'" class="btn btn-sm bg-danger-light export_class d-flex">
                    <div class="badge badge-success" style="font-size:14px;">
                        <i class="fas fa-table"></i> Export to Excel
                    </div>
                    </a>
                </td>
            </tr>';
            }
        $query .= '</tbody></table>';
        return response()->json([
        'status'=>'success',
        'query'=> $query
        ]);
    }
    public function fetchViewClass(Request $request){
        $user_id = auth()->user()->id;
        $classes = DB::table('class')->select('*', 'class.id as cid','subject.grade_level AS class_glevel')->join('subject', 'subject.id', '=', 'class.subject_id')->join('student_subject', 'student_subject.subject_id', '=', 'subject.id')->join('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->join('school_year', 'school_year.id', '=', 'class.sy_id')->where('class.id', $request->id)->get();
        $classes_sel = DB::table('class')->select('*', 'class.id as cid','subject.grade_level AS class_glevel')->join('subject', 'subject.id', '=', 'class.subject_id')->join('school_year', 'school_year.id', '=', 'class.sy_id')->where('class.id', $request->id)->first();
        $query = '<table class="table border-0 star-student table-hover table-center mb-0 datatables_class table-striped">
            <thead class="student-thread">
                <tr>
                    <th>LRN Number</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Grade Level & Section</th>
                </tr>
            </thead>
            <tbody>';
            foreach($classes as $class){
                $query .= '<tr>
                <td>'.$class->lrn_number.'</td>
                <td>'.$class->firstname.' '.$class->lastname.'</td>
                <td>'.$class->gender.'</td>
                <td>'.$class->grade_level.' '.$class->section.'</td>
                </tr>';
            }
        $query .= '</tbody></table>';
        return response()->json([
        'status'=>'success',
        'query'=> $query,
        'class' => $classes_sel
        ]);
    }
    public function fetchGrades(Request $request){
        $user_id = auth()->user()->id;
        $classes = Classes::select('*', 'class.id as cid','subject.grade_level AS class_glevel', DB::raw('COUNT(student_personal_details.id) AS ctr'))->join('subject', 'subject.id', '=', 'class.subject_id')->leftJoin('student_subject', 'student_subject.subject_id', '=', 'subject.id')->leftJoin('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->join('school_year', 'school_year.id', '=', 'class.sy_id')->leftJoin('grades_per_subject', 'grades_per_subject.student_subject_id', '=', 'student_subject.id')->where('class.faculty_id', $user_id)->groupBy('class.subject_id')->get();
        $grades = Grade::select('*', 'class.id as cid', 'grades_per_subject.id as gid', 'subject.grade_level as glevel', 'faculty_staff_personal_details.firstname as ffname', 'faculty_staff_personal_details.lastname as flname')->join('student_subject', 'student_subject.id', '=', 'grades_per_subject.student_subject_id')->join('subject', 'subject.id', '=', 'student_subject.subject_id')->join('class', 'class.subject_id', '=', 'subject.id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->join('school_year', 'school_year.id', '=', 'student_subject.sy_id')->groupBy('class.faculty_id')->get();
        $query = '<table class="table border-0 star-student table-hover table-center mb-0 datatable_grades table-striped">
            <thead class="student-thread">
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Description</th>
                    <th>Grade Level</th>
                    <th>Credits</th>
                    <th>Grade Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>';
            foreach($classes as $class){
                $query .= '<tr>
                <td>'.$class->subject_code.'</td>
                <td>'.$class->subject_description.'</td>
                <td>'.$class->class_glevel.'</td>
                <td>'.$class->credits.'</td>';
                if($class->statusFirstQ == 'Pending' && $class->statusSecondQ == 'To Be Encoded' && $class->statusThirdQ == 'To Be Encoded' && $class->statusFourthQ == 'To Be Encoded'){
                    $query .= '<td style="width: 20% !important; white-space: normal !important;"><strong>For Validation: </strong>'.$class->from_year.' - '.$class->to_year.' 1st Quarter Grades</td>
                    <td style="width: 10% !important;"><button id="'.$class->cid.'" class="btn btn-sm bg-danger-light input_grades d-flex">
                    <div class="badge badge-success" style="font-size:14px;">
                        <i class="feather-edit"></i> Input Grades
                        </div>
                    </button>';
                }else if($class->statusFirstQ == 'Pending' && $class->statusSecondQ == 'Pending' && $class->statusThirdQ == 'To Be Encoded' && $class->statusFourthQ == 'To Be Encoded'){
                    $query .= '<td style="width: 20% !important; white-space: normal !important;"><strong>For Validation: </strong>'.$class->from_year.' - '.$class->to_year.' 1st & 2nd Quarter Grades</td>
                    <td style="width: 10% !important;"><button id="'.$class->cid.'" class="btn btn-sm bg-danger-light input_grades d-flex">
                    <div class="badge badge-success" style="font-size:14px;">
                        <i class="feather-edit"></i> Input Grades
                        </div>
                    </button>';
                }else if($class->statusFirstQ == 'Pending' && $class->statusSecondQ == 'Pending' && $class->statusThirdQ == 'Pending' && $class->statusFourthQ == 'To Be Encoded'){
                    $query .= '<td style="width: 20% !important; white-space: normal !important;"><strong>For Validation: </strong>'.$class->from_year.' - '.$class->to_year.' 1st, 2nd, & 3rd Quarter Grades</td>
                    <td style="width: 10% !important;"><button id="'.$class->cid.'" class="btn btn-sm bg-danger-light input_grades d-flex">
                    <div class="badge badge-success" style="font-size:14px;">
                        <i class="feather-edit"></i> Input Grades
                        </div>
                    </button>';
                }else if($class->statusFirstQ == 'Pending' && $class->statusSecondQ == 'Pending' && $class->statusThirdQ == 'Pending' && $class->statusFourthQ == 'Pending'){
                    $query .= '<td style="width: 20% !important; white-space: normal !important;"><strong>For Validation: </strong>'.$class->from_year.' - '.$class->to_year.' 1st, 2nd, 3rd, & 4th Quarter Grades</td>
                    <td style="width: 10% !important;"><button id="'.$class->cid.'" class="btn btn-sm bg-danger-light view_grades d-flex">
                    <div class="badge badge-success" style="font-size:14px;">
                        <i class="fas fa-eye"></i> View Grades
                        </div>
                    </button>';
                }else if($class->statusFirstQ == 'Approved' && $class->statusSecondQ == 'Pending' && $class->statusThirdQ == 'To Be Encoded' && $class->statusFourthQ == 'To Be Encoded'){
                    $query .= '<td style="width: 20% !important; white-space: normal !important;"><strong>For Validation: </strong>'.$class->from_year.' - '.$class->to_year.' 2nd Quarter Grades</td>
                    <td style="width: 10% !important;"><button id="'.$class->cid.'" class="btn btn-sm bg-danger-light input_grades d-flex">
                    <div class="badge badge-success" style="font-size:14px;">
                        <i class="feather-edit"></i> Input Grades
                        </div>
                    </button>';
                }else if($class->statusFirstQ == 'Approved' && $class->statusSecondQ == 'Approved' && $class->statusThirdQ == 'Pending' && $class->statusFourthQ == 'To Be Encoded'){
                    $query .= '<td style="width: 20% !important; white-space: normal !important;"><strong>For Validation: </strong>'.$class->from_year.' - '.$class->to_year.' 3rd Quarter Grades</td>
                    <td style="width: 10% !important;"><button id="'.$class->cid.'" class="btn btn-sm bg-danger-light input_grades d-flex">
                    <div class="badge badge-success" style="font-size:14px;">
                        <i class="feather-edit"></i> Input Grades
                        </div>
                    </button>';
                }else if($class->statusFirstQ == 'Approved' && $class->statusSecondQ == 'Approved' && $class->statusThirdQ == 'Approved' && $class->statusFourthQ == 'Pending'){
                    $query .= '<td style="width: 20% !important;white-space: normal !important;"><strong>For Validation: </strong>'.$class->from_year.' - '.$class->to_year.' 4th Quarter Grades</td>
                    <td style="width: 10% !important;"><button id="'.$class->cid.'" class="btn btn-sm bg-danger-light view_grades d-flex">
                    <div class="badge badge-success" style="font-size:14px;">
                        <i class="fas fa-eye"></i> View Grades
                        </div>
                    </button>';
                }else if($class->statusFirstQ == null && $class->statusSecondQ == null && $class->statusThirdQ == null && $class->statusFourthQ == null){
                    $query .= '<td style="width: 20% !important;white-space: normal !important;">NULL</td>
                    <td style="width: 10% !important;"><button id="'.$class->cid.'" class="btn btn-sm bg-danger-light input_grades d-flex">
                    <div class="badge badge-success" style="font-size:14px;">
                        <i class="feather-edit"></i> Input Grades
                        </div>
                    </button>';
                }else{
                    $query .= '<td style="width: 20% !important;"><div class="badge badge-success" style="font-size:14px;">Approved</div></td>
                    <td style="width: 10% !important;"><button id="'.$class->cid.'" class="btn btn-sm bg-danger-light view_grades d-flex">
                    <div class="badge badge-success" style="font-size:14px;">
                        <i class="fas fa-eye"></i> View Grades
                        </div>
                    </button>';
                }
                $query .='</tr>';
            }
        $query .= '</tbody></table>';
        return response()->json([
        'status'=>'success',
        'query'=> $query
        ]);
    }
    public function fetchViewAdvisees(Request $request){
        $user_id = auth()->user()->id;
            $students = StudentUser::select('*', 'student_personal_details.firstname AS sfname', 'student_personal_details.lastname AS slname', 'student_personal_details.gender AS sgender')->join('student_subject', 'student_subject.student_id', '=', 'student_personal_details.id')->join('subject', 'subject.id', '=', 'student_subject.subject_id')->leftJoin('class', 'class.subject_id', '=', 'subject.id')->leftJoin('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->leftJoin('grades_per_subject', 'grades_per_subject.student_subject_id', '=', 'student_subject.id')->join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->where('student_personal_details.id', $request->id)->get();
            $student_sel = StudentUser::join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->where('student_personal_details.id', $request->id)->first();
            // $grades = StudentUser::join('student_subject', 'student_subject.student_id', '=', 'student_personal_details.id')->join('grades_per_subject', 'grades_per_subject.student_subject_id', '=', 'student_subject.id')->where('student_subject.student_id', $request->id)->where(function($query) {
            //     	$query->orWhere('grades_per_subject.firstQ', '<', 80)
            //     				->orWhere('grades_per_subject.secondQ', '<', 80)
            //                     ->orWhere('grades_per_subject.thirdQ', '<', 80)
            //                     ->orWhere('grades_per_subject.fourthQ', '<', 80);
            // })->count();
            
            $query = '<table class="table border-0 star-student table-hover table-center mb-0 datatables_advisees table-striped">
            <thead class="student-thread">
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
                            <td style="width: 6%; text-align:center;">'. $student->firstQ ;
                            if($student->statusFirstQ == 'Approved'){
                                $query .='</td>';
                            }else{
                                $query .='<div><small class="text-muted" style="text-transform: uppercase; font-style: italic;">'.$student->statusFirstQ.'</small></div></td>';
                            }
                            $query .='<td style="width: 6%; text-align:center;">'. $student->secondQ;
                            if($student->statusSecondQ == 'Approved'){
                                $query .='</td>';
                            }else{
                                $query .='<div><small class="text-muted" style="text-transform: uppercase; font-style: italic;">'.$student->statusSecondQ.'</small></div></td>';
                            }
                            $query .= '<td style="width: 6%; text-align:center;">'. $student->thirdQ;
                            if($student->statusThirdQ == 'Approved'){
                                $query .='</td>';
                            }else{
                                $query .='<div><small class="text-muted" style="text-transform: uppercase; font-style: italic;">'.$student->statusThirdQ.'</small></div></td>';
                            }
                            $query .= '<td style="width: 6%; text-align:center;">'. $student->fourthQ;
                            if($student->statusFourthQ == 'Approved'){
                                $query .='</td>';
                            }else{
                                $query .='<div><small class="text-muted" style="text-transform: uppercase; font-style: italic;">'.$student->statusFourthQ.'</small></div></td>';
                            }
                            if($student->fourthQ == null || $student->statusFourthQ == 'Pending'){
                                $query .= '<td style="width: 6%; text-align:center; font-weight:bold; color:blue; background-color: #FFFBC8;"></td>
                                            <td style="width: 5%; text-align:center; font-weight:bold; color:#b3b3b3; background-color: #D6EEEE;"></td>';
                            }else{
                                $query .= '<td style="width: 6%; text-align:center; font-weight:bold; color:#05300e; background-color: #FFFBC8;">'. $student->cumulative_gpa .'</td>';
                                if($student->cumulative_gpa < 75){
                                $query .= '<td style="width: 5%; text-align:center; font-weight:bold; color:red; background-color: #D6EEEE;">FAILED</td>';
                                }else{
                                $query .= '<td style="width: 5%; text-align:center; font-weight:bold; color:green; background-color: #D6EEEE;">PASSED</td>';
                                }
                            }
                $query .= '</tr>';
            }
            $query .= '</tbody></table>';
        return response()->json([
            'status'=>'success',
            'query'=> $query,
            'student' => $student_sel
        ]);
    }
    public function fetchInputGrades(Request $request){
        $user_id = auth()->user()->id;
        $currSY = SchoolYear::select('*')->where('isCurrent', 1)->first();
        $classes = DB::table('class')->select('*', 'student_personal_details.id as stud_id' , 'student_subject.id as subj_id', 'class.id as cid', 'student_gradelevel_section.grade_level AS glevel')->join('subject', 'subject.id', '=', 'class.subject_id')->join('student_subject', 'student_subject.subject_id', '=', 'subject.id')->join('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->leftJoin('grades_per_subject', 'grades_per_subject.student_subject_id', '=', 'student_subject.id')->join('school_year', 'school_year.id', '=', 'class.sy_id')->where('class.id', $request->id)->get();
        $classes_sel = DB::table('class')->select('*', 'class.id as cid','subject.grade_level AS class_glevel')->join('subject', 'subject.id', '=', 'class.subject_id')->join('school_year', 'school_year.id', '=', 'class.sy_id')->where('class.id', $request->id)->first();
        $query = '<table class="table border-0 star-student table-hover table-center mb-0 datatables_grades table-striped">
            <thead class="student-thread">
                <tr>
                    <th>LRN Number</th>
                    <th>Name</th>
                    <th style="font-size:14px; font-weight:bold; text-align:center;">1st</th>
                    <th style="font-size:14px; font-weight:bold; text-align:center;">2nd</th>
                    <th style="font-size:14px; font-weight:bold; text-align:center;">3rd</th>
                    <th style="font-size:14px; font-weight:bold; text-align:center;">4th</th>
                    <th style="font-size:14px; font-weight:bold; text-align:center;">Final</th>				  		
                    <th style="font-size:14px; font-weight:bold; text-align:center;">Remarks</th>
                </tr>
            </thead>
            <tbody>';
            foreach($classes as $class){
                $query .= '<tr>
                <input id="stud_id" value="'.$class->stud_id.'" class="form-control" name="stud_id[]" hidden>
                <input id="sid" value="'.$class->cid.'" class="form-control" name="sid" hidden>
                <input id="subj_id" value="'.$class->subj_id.'" class="form-control" name="subj_id[]" hidden>
                <input id="glevel" value="'.$class->glevel.'" class="form-control" name="glevel" hidden>
                <td style="width: 10% !important;">'.$class->lrn_number.'</td>
                <td style="width: 20% !important;">'.$class->firstname.' '.$class->lastname.'</td>';
                if($class->firstQ != null){
                    $query .= '<td style="width: 10% !important; text-align:center;"><input id="firstQ" value="'. $class->firstQ .'" class="form-control" name="firstQ[]" hidden><strong style="font-size:14px; color:#05300e">'.$class->firstQ.' % </strong>';
                    if($class->statusFirstQ == 'Pending'){
                        $query .='<div class="badge badge-warning" style="font-size:10px; text-transform: uppercase; font-style: italic;">'.$class->statusFirstQ.'</div></td>';
                    }else{
                        $query .='<div class="badge badge-success" style="font-size:10px; text-transform: uppercase; font-style: italic;">'.$class->statusFirstQ.'</div></td>';
                    }
                }else{
                    if($currSY->quarter == '1st Quarter' || $currSY->quarter == '2nd Quarter' || $currSY->quarter == '3rd Quarter' || $currSY->quarter == '4th Quarter'){
                        $query .= '<td style="width: 10% !important; text-align:center;"><input id="firstQ" class="form-control" name="firstQ[]" type="number" step="0.01" max="100" required=""></td>';
                    }else{
                        $query .= '<td style="width: 10% !important; text-align:center;"><input id="firstQ" class="form-control" name="firstQ[]" type="number" step="0.01" readonly></td>';
                    }
                }
                if($class->secondQ != null){
                    $query .= '<td style="width: 10% !important; text-align:center;"><input id="secondQ" value="'. $class->secondQ .'" class="form-control" name="secondQ[]" hidden><strong style="font-size:14px; color:#05300e">'.$class->secondQ.' % </strong>';
                    if($class->statusSecondQ == 'Pending'){
                        $query .='<div class="badge badge-warning" style="font-size:10px; text-transform: uppercase; font-style: italic;">'.$class->statusSecondQ.'</div></td>';
                    }else{
                        $query .='<div class="badge badge-success" style="font-size:10px; text-transform: uppercase; font-style: italic;">'.$class->statusSecondQ.'</div></td>';
                    }
                }else{
                    if($currSY->quarter == '2nd Quarter' || $currSY->quarter == '3rd Quarter' || $currSY->quarter == '4th Quarter'){
                        $query .= '<td style="width: 10% !important; text-align:center;"><input id="secondQ" class="form-control" name="secondQ[]" type="number" step="0.01" max="100" required=""></td>';
                    }else{
                        $query .= '<td style="width: 10% !important; text-align:center;"><input id="secondQ" class="form-control" name="secondQ[]" type="number" step="0.01" readonly></td>';
                    }
                }
                if($class->thirdQ != null){
                    $query .= '<td style="width: 10% !important; text-align:center;"><input id="thirdQ" value="'. $class->thirdQ .'" class="form-control" name="thirdQ[]" hidden><strong style="font-size:14px; color:#05300e">'.$class->thirdQ.' % </strong>';
                    if($class->statusThirdQ == 'Pending'){
                        $query .='<div class="badge badge-warning" style="font-size:10px; text-transform: uppercase; font-style: italic;">'.$class->statusThirdQ.'</div></td>';
                    }else{
                        $query .='<div class="badge badge-success" style="font-size:10px; text-transform: uppercase; font-style: italic;">'.$class->statusThirdQ.'</div></td>';
                    }
                }else{
                    if($currSY->quarter == '3rd Quarter' || $currSY->quarter == '4th Quarter'){
                        $query .= '<td style="width: 10% !important; text-align:center;"><input id="thirdQ" class="form-control" name="thirdQ[]" type="number" step="0.01" max="100" required=""></td>';
                    }else{
                        $query .= '<td style="width: 10% !important; text-align:center;"><input id="thirdQ" class="form-control" name="thirdQ[]" type="number" step="0.01" readonly></td>';
                    }
                }
                if($class->fourthQ != null){
                    $query .= '<td style="width: 10% !important; text-align:center;"><input id="fourthQ" value="'. $class->fourthQ .'" class="form-control" name="fourthQ[]" hidden><strong style="font-size:14px; color:#05300e">'.$class->fourthQ.' % </strong>';
                    if($class->statusFourthQ == 'Pending'){
                        $query .='<div class="badge badge-warning" style="font-size:10px; text-transform: uppercase; font-style: italic;">'.$class->statusFourthQ.'</div></td>';
                    }else{
                        $query .='<div class="badge badge-success" style="font-size:10px; text-transform: uppercase; font-style: italic;">'.$class->statusFourthQ.'</div></td>';
                    }
                }else{
                    if($currSY->quarter == '4th Quarter'){
                        $query .= '<td style="width: 10% !important; text-align:center;"><input id="fourthQ" class="form-control" name="fourthQ[]" type="number" step="0.01" max="100" required=""></td>';
                    }else{
                        $query .= '<td style="width: 10% !important; text-align:center;"><input id="fourthQ" class="form-control" name="fourthQ[]" type="number" step="0.01" readonly></td>';
                    }
                }
                if($class->fourthQ == null || $class->statusFourthQ == 'Pending'){
                    $query .= '<td style="width: 15% !important; text-align:center;"></td>
                    <td style="width: 15% !important; text-align:center;"></td>';
                }else{
                    $query .= '<td style="width: 15% !important; text-align:center;"><div class="badge badge-success" style="font-size:14px;">'.$class->cumulative_gpa.' % </div></td>';
                    if($class->cumulative_gpa < 75){
                        $query .= '<td style="width: 15% !important; text-align:center;"><strong style="font-size:14px; color:#FF0000">FAILED</strong></td>';
                    }else{
                        $query .= '<td style="width: 15% !important; text-align:center;"><strong style="font-size:14px; color:#008000">PASSED</strong></td>';
                    }
                }
                $query .='</tr>';
            }
        $query .= '</tbody></table>';
        return response()->json([
        'status'=>'success',
        'query'=> $query,
        'class' => $classes_sel
        ]);
    }
    public function submitGrades(Request $request){
        DB::beginTransaction();
        $subjectIds = $request->subj_id;
        $data = $request->all(); // Assuming this is an array of subject IDs
        foreach ($subjectIds as $id) {
        $temp = Grade::where('student_subject_id', $id)->count();
        if($temp){
            foreach ($subjectIds as $key => $subjectId) {
            $grades = Grade::where('student_subject_id', $subjectId)->first();
            $grades->student_subject_id = $subjectId;
            $grades->grade_level = $request->glevel;
            $grades->firstQ = $data['firstQ'][$key];
            $grades->secondQ = $data['secondQ'][$key];
            $grades->thirdQ = $data['thirdQ'][$key];
            $grades->fourthQ = $data['fourthQ'][$key];
            $grades->cumulative_gpa = ($data['firstQ'][$key] + $data['secondQ'][$key] + $data['thirdQ'][$key] + $data['fourthQ'][$key])/4;
            if($data['firstQ'][$key] != null && $grades->date_submitted_firstQ == null){
                $grades->statusFirstQ = 'Pending';
                $grades->date_submitted_firstQ = date('Y-m-d H:i:s');
            }
            if($data['secondQ'][$key] != null && $grades->date_submitted_secondQ == null){
                $grades->statusSecondQ = 'Pending';
                $grades->date_submitted_secondQ = date('Y-m-d H:i:s');
            }
            if($data['thirdQ'][$key] != null && $grades->date_submitted_thirdQ == null){
                $grades->statusThirdQ = 'Pending';
                $grades->date_submitted_thirdQ = date('Y-m-d H:i:s');
            }
            if($data['fourthQ'][$key] != null && $grades->date_submitted_fourthQ == null){
                $grades->statusFourthQ = 'Pending';
                $grades->date_submitted_fourthQ = date('Y-m-d H:i:s');
            }
            $grades->update();
            }
        }else{
            foreach ($subjectIds as $key => $subjectId) {
            $grades = new Grade;
            $grades->student_subject_id = $subjectId;
            $grades->grade_level = $request->glevel;
            $grades->firstQ = $data['firstQ'][$key];
            $grades->secondQ = $data['secondQ'][$key];
            $grades->thirdQ = $data['thirdQ'][$key];
            $grades->fourthQ = $data['fourthQ'][$key];
            $grades->cumulative_gpa = ($data['firstQ'][$key] + $data['secondQ'][$key] + $data['thirdQ'][$key] + $data['fourthQ'][$key])/4;
            if($data['firstQ'][$key] != null && $grades->date_submitted_firstQ == null){
                $grades->statusFirstQ = 'Pending';
                $grades->date_submitted_firstQ = date('Y-m-d H:i:s');
            }
            if($data['secondQ'][$key] != null && $grades->date_submitted_secondQ == null){
                $grades->statusSecondQ = 'Pending';
                $grades->date_submitted_secondQ = date('Y-m-d H:i:s');
            }
            if($data['thirdQ'][$key] != null && $grades->date_submitted_thirdQ == null){
                $grades->statusThirdQ = 'Pending';
                $grades->date_submitted_thirdQ = date('Y-m-d H:i:s');
            }
            if($data['fourthQ'][$key] != null && $grades->date_submitted_fourthQ == null){
                $grades->statusFourthQ = 'Pending';
                $grades->date_submitted_fourthQ = date('Y-m-d H:i:s');
            }
            $grades->save();
            }
        }
        }
        DB::commit();
        return response()->json([
            'status'=>'success'
        ]);
    }
    public function updateGrades(Request $request){
        $grades = Grade::join('student_subject', 'student_subject.id', '=', 'grades_per_subject.student_subject_id')->join('subject', 'subject.id', '=', 'student_subject.subject_id')->join('class', 'class.subject_id', '=', 'class.subject_id')->join('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->where('student_personal_details.id', $request->stud_id)->first();
        $grades->student_subject_id = $request->subj_id;
        $grades->firstQ = $request->firstQ;
        $grades->secondQ = $request->secondQ;
        $grades->thirdQ = $request->thirdQ;
        $grades->fourthQ = $request->fourthQ;
        $grades->save();
    }
    public function fetchAdvisees(Request $request){
        $user_id = auth()->user()->id;
        $class_advisory_ctr = ClassAdvisory::where('faculty_id', $user_id)->get();
        $class_advisory = StudentUser::select('*', 'class_advisory.id as caid', 'student_personal_details.id AS sid', 'student_personal_details.firstname AS sfname', 'student_personal_details.lastname AS slname', 'student_personal_details.gender AS sgender','student_gradelevel_section.grade_level as glevel')->join('class_advisory', 'class_advisory.glevel_section_id', '=', 'student_personal_details.glevel_section_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class_advisory.faculty_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->join('student_subject', 'student_subject.student_id', '=', 'student_personal_details.id')->join('grades_per_subject', 'grades_per_subject.student_subject_id', '=', 'student_subject.id')->join('school_year', 'school_year.id', '=', 'class_advisory.sy_id')->groupBy('student_personal_details.id')->where('class_advisory.faculty_id', $user_id)->get();
        
        $query = '<table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
            <thead class="student-thread">
                <tr>
                    <th>LRN Number</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Deficiency Status</th>
                    <th class="text-end">Honors Candidates</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>';
            foreach($class_advisory as $advisees){
                $ctr = 0;
        $stud_subj = StudentSubjects::where('student_id', $advisees->sid)->get();
        foreach($stud_subj as $temp){
            $ctr += Grade::where('student_subject_id', $temp->id)->where('firstQ', '<', 80)->count();
            $ctr += Grade::where('student_subject_id', $temp->id)->where('secondQ', '<', 80)->count();
            $ctr += Grade::where('student_subject_id', $temp->id)->where('thirdQ', '<', 80)->count();
            $ctr += Grade::where('student_subject_id', $temp->id)->where('fourthQ', '<', 80)->count();
        }
                $query .= '<tr>
                <td>'.$advisees->lrn_number.'</td>
                <td>'.$advisees->sfname.' '.$advisees->slname.'</td>
                <td>'.$advisees->sgender.'</td>
                <td>None</td>';
                if($ctr == 0){
                    $query .= '<td class="text-center"><div class="badge badge-success" style="font-size:14px;">Yes</div></td>';
                }else{
                    $query .= '<td class="text-center"><div class="badge badge-danger" style="font-size:14px;">No<small class="d-flex" style="font-style:italic">Has '.$ctr;
                    if($ctr > 1){
                        $query .= ' grades below 80</small></div></td>';
                    }else{
                        $query .= ' grade below 80</small></div></td>';
                    }
                }
                $query .= '<td>
                    <a id="'.$advisees->sid.'" class="btn btn-sm bg-danger-light view_advisees d-flex">
                    <div class="badge badge-warning" style="font-size:14px;">
                        <i class="fas fa-eye"></i> View Grades
                        </div>
                    </a>
                    <a href="'. route("advisees.pdf", ['id' => $advisees->sid]) .'" target="_blank" id="'.$advisees->sid.'" class="btn btn-sm bg-danger-light print_class d-flex">
                    <div class="badge badge-success" style="font-size:14px;">
                        <i class="fas fa-print"></i> Print Student Grades
                    </div>
                    </a>
                    <button id="'.$advisees->sid.'" class="btn btn-sm bg-danger-light message_btn d-flex">
                    <div class="badge badge-info" style="font-size:14px;">
                        <i class="fas fa-paper-plane"></i> Message
                        </div>
                    </button>
                </td>
            </tr>';
            }
        $query .= '</tbody></table>';
        return response()->json([
        'status'=>'success',
        'query'=> $query
        ]);
    }
}
