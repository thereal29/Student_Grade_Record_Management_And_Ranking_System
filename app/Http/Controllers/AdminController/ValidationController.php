<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolYear;
use App\Models\Grade;
use App\Models\StudentUser;
use App\Models\Classes;
use Illuminate\Support\Facades\DB;

class ValidationController extends Controller
{
    public function grades_index(){
        $schoolyear = SchoolYear::select('*')->groupBy('school_year.from_year')->get();
        return view('admin.modules.validation.student_grades.index', compact('schoolyear'));
    }
    public function co_curricular_activity_index(){
        $schoolyear = SchoolYear::select('*')->groupBy('school_year.from_year')->get();
        return view('admin.modules.validation.co_curricular_activity.index', compact('schoolyear'));
    }
    public function fetchStudentGrades(Request $request){
        if($request->sy == null || $request->sy == 'showall'){
            $grades = Grade::select('*', 'class.id as cid', 'grades_per_subject.id as gid', 'subject.grade_level as glevel', 'faculty_staff_personal_details.firstname as ffname', 'faculty_staff_personal_details.lastname as flname')->join('student_subject', 'student_subject.id', '=', 'grades_per_subject.student_subject_id')->join('subject', 'subject.id', '=', 'student_subject.subject_id')->join('class', 'class.subject_id', '=', 'subject.id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->join('school_year', 'school_year.id', '=', 'student_subject.sy_id')->groupBy('class.subject_id')->get();
        }
        else{
            $grades = Grade::select('*', 'class.id as cid', 'grades_per_subject.id as gid', 'subject.grade_level as glevel', 'faculty_staff_personal_details.firstname as ffname', 'faculty_staff_personal_details.lastname as flname')->join('student_subject', 'student_subject.id', '=', 'grades_per_subject.student_subject_id')->join('subject', 'subject.id', '=', 'student_subject.subject_id')->join('class', 'class.subject_id', '=', 'subject.id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->join('school_year', 'school_year.id', '=', 'student_subject.sy_id')->where('school_year.from_year', $request->sy)->groupBy('class.faculty_id')->get();
        }
            $query = '<table class="table border-0 star-student table-hover table-center mb-0 datatables table-striped">
            <thead class="student-thread">
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Faculty</th>
                    <th>Grade Level</th>
                    <th>Date Submitted</th>
                    <th>To Validate</th>
                    <th>Action</th>
                </tr>
            </thead>';
            foreach($grades as $key=>$grade){
                $query .= '<tr>
                <td style="width: 3% !important;">'.++$key.'</td>
                <td style="width: 22% !important;">'.$grade->subject_code.' | '.$grade->subject_description.'</td>
                <td style="width: 20% !important;">'.$grade->ffname.' '.$grade->flname.'</td>
                <td style="width: 10% !important;">'.$grade->glevel.'</td>';
                if($grade->statusFirstQ == 'Pending' && $grade->statusSecondQ == 'To Be Encoded' && $grade->statusThirdQ == 'To Be Encoded' && $grade->statusFourthQ == 'To Be Encoded'){
                    $query .= '<td style="width: 15% !important;">'.$grade->date_submitted_firstQ.'</td>
                    <td style="width: 20% !important; white-space: normal !important;">'.$grade->from_year.' - '.$grade->to_year.' 1st Quarter Grades</td>
                    <td style="width: 10% !important;"><button id="'.$grade->cid.'" class="btn btn-sm bg-danger-light view_approval d-flex">
                    <div class="badge badge-success" style="font-size:14px;">
                        <i class="feather-edit"></i> Approve Grades
                        </div>
                    </button>';
                }else if($grade->statusFirstQ == 'Pending' && $grade->statusSecondQ == 'Pending' && $grade->statusThirdQ == 'To Be Encoded' && $grade->statusFourthQ == 'To Be Encoded'){
                    $query .= '<td style="width: 15% !important;">'.$grade->date_submitted_secondQ.'</td>
                    <td style="width: 20% !important; white-space: normal !important;">'.$grade->from_year.' - '.$grade->to_year.' 1st & 2nd Quarter Grades</td>
                    <td style="width: 10% !important;"><button id="'.$grade->cid.'" class="btn btn-sm bg-danger-light view_approval d-flex">
                    <div class="badge badge-success" style="font-size:14px;">
                        <i class="feather-edit"></i> Approve Grades
                        </div>
                    </button>';
                }else if($grade->statusFirstQ == 'Pending' && $grade->statusSecondQ == 'Pending' && $grade->statusThirdQ == 'Pending' && $grade->statusFourthQ == 'To Be Encoded'){
                    $query .= '<td style="width: 15% !important;">'.$grade->date_submitted_thirdQ.'</td>
                    <td style="width: 20% !important; white-space: normal !important;">'.$grade->from_year.' - '.$grade->to_year.' 1st, 2nd, & 3rd Quarter Grades</td>
                    <td style="width: 10% !important;"><button id="'.$grade->cid.'" class="btn btn-sm bg-danger-light view_approval d-flex">
                    <div class="badge badge-success" style="font-size:14px;">
                        <i class="feather-edit"></i> Approve Grades
                        </div>
                    </button>';
                }else if($grade->statusFirstQ == 'Pending' && $grade->statusSecondQ == 'Pending' && $grade->statusThirdQ == 'Pending' && $grade->statusFourthQ == 'Pending'){
                    $query .= '<td style="width: 15% !important;">'.$grade->date_submitted_fourthQ.'</td>
                    <td style="width: 20% !important; white-space: normal !important;">'.$grade->from_year.' - '.$grade->to_year.' 1st, 2nd, 3rd, & 4th Quarter Grades</td>
                    <td style="width: 10% !important;"><button id="'.$grade->cid.'" class="btn btn-sm bg-danger-light view_approval d-flex">
                    <div class="badge badge-success" style="font-size:14px;">
                        <i class="feather-edit"></i> Approve Grades
                        </div>
                    </button>';
                }else if($grade->statusFirstQ == 'Approved' && $grade->statusSecondQ == 'Pending' && $grade->statusThirdQ == 'To Be Encoded' && $grade->statusFourthQ == 'To Be Encoded'){
                    $query .= '<td style="width: 15% !important;">'.$grade->date_submitted_secondQ.'</td>
                    <td style="width: 20% !important; white-space: normal !important;">'.$grade->from_year.' - '.$grade->to_year.' 2nd Quarter Grades</td>
                    <td style="width: 10% !important;"><button id="'.$grade->cid.'" class="btn btn-sm bg-danger-light view_approval d-flex">
                    <div class="badge badge-success" style="font-size:14px;">
                        <i class="feather-edit"></i> Approve Grades
                        </div>
                    </button>';
                }else if($grade->statusFirstQ == 'Approved' && $grade->statusSecondQ == 'Approved' && $grade->statusThirdQ == 'Pending' && $grade->statusFourthQ == 'To Be Encoded'){
                    $query .= '<td style="width: 15% !important;">'.$grade->date_submitted_thirdQ.'</td>
                    <td style="width: 20% !important; white-space: normal !important;">'.$grade->from_year.' - '.$grade->to_year.' 3rd Quarter Grades</td>
                    <td style="width: 10% !important;"><button id="'.$grade->cid.'" class="btn btn-sm bg-danger-light view_approval d-flex">
                    <div class="badge badge-success" style="font-size:14px;">
                        <i class="feather-edit"></i> Approve Grades
                        </div>
                    </button>';
                }else if($grade->statusFirstQ == 'Approved' && $grade->statusSecondQ == 'Approved' && $grade->statusThirdQ == 'Approved' && $grade->statusFourthQ == 'Pending'){
                    $query .= '<td style="width: 15% !important;">'.$grade->date_submitted_fourthQ.'</td>
                    <td style="width: 20% !important;white-space: normal !important;">'.$grade->from_year.' - '.$grade->to_year.' 4th Quarter Grades</td>
                    <td style="width: 10% !important;"><button id="'.$grade->cid.'" class="btn btn-sm bg-danger-light view_approval d-flex">
                    <div class="badge badge-success" style="font-size:14px;">
                        <i class="feather-edit"></i> Approve Grades
                        </div>
                    </button>';
                }else{
                    if($grade->date_submitted_firstQ != null && $grade->date_submitted_secondQ == null && $grade->date_submitted_thirdQ == null && $grade->date_submitted_fourthQ == null){
                        $query .= '<td style="width: 15% !important;">'.$grade->date_submitted_firstQ.'</td>';
                    }else if($grade->date_submitted_firstQ != null && $grade->date_submitted_secondQ != null && $grade->date_submitted_thirdQ == null && $grade->date_submitted_fourthQ == null){
                        $query .= '<td style="width: 15% !important;">'.$grade->date_submitted_secondQ.'</td>';
                    }else if($grade->date_submitted_firstQ != null && $grade->date_submitted_secondQ != null && $grade->date_submitted_thirdQ != null && $grade->date_submitted_fourthQ == null){
                        $query .= '<td style="width: 15% !important;">'.$grade->date_submitted_thirdQ.'</td>';
                    }else{
                        $query .= '<td style="width: 15% !important;">'.$grade->date_submitted_fourthQ.'</td>';
                    }
                    $query .= '<td style="width: 20% !important;"><div class="badge badge-success" style="font-size:14px;">Approved</div></td>
                    <td style="width: 10% !important;"><button id="'.$grade->cid.'" class="btn btn-sm bg-danger-light view_approved d-flex">
                    <div class="badge badge-success" style="font-size:14px;">
                        <i class="fas fa-eye"></i> View Approval
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
    public function fetchViewGradesValidation(Request $request){
        $user_id = auth()->user()->id;
        $currSY = SchoolYear::select('*')->where('isCurrent', 1)->first();
        $classes = Classes::select('*', 'student_personal_details.id as stud_id' , 'student_subject.id as subj_id', 'class.id as cid', 'student_gradelevel_section.grade_level AS glevel')->join('subject', 'subject.id', '=', 'class.subject_id')->join('student_subject', 'student_subject.subject_id', '=', 'subject.id')->join('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->leftJoin('grades_per_subject', 'grades_per_subject.student_subject_id', '=', 'student_subject.id')->join('school_year', 'school_year.id', '=', 'class.sy_id')->where('class.id', $request->id)->get();
        $classes_sel = Classes::select('*', 'class.id as cid','subject.grade_level AS class_glevel')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->join('subject', 'subject.id', '=', 'class.subject_id')->join('school_year', 'school_year.id', '=', 'class.sy_id')->where('class.id', $request->id)->first();
        $query = '<table class="table border-0 star-student table-hover table-center mb-0 datatables_validate table-striped">
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
                        $query .= '<td style="width: 10% !important; text-align:center;"><input id="firstQ" class="form-control" name="firstQ[]" type="number" step="0.01" hidden></td>';
                }
                if($class->secondQ != null){
                    $query .= '<td style="width: 10% !important; text-align:center;"><input id="secondQ" value="'. $class->secondQ .'" class="form-control" name="secondQ[]" hidden><strong style="font-size:14px; color:#05300e">'.$class->secondQ.' % </strong>';
                    if($class->statusSecondQ == 'Pending'){
                        $query .='<div class="badge badge-warning" style="font-size:10px; text-transform: uppercase; font-style: italic;">'.$class->statusSecondQ.'</div></td>';
                    }else{
                        $query .='<div class="badge badge-success" style="font-size:10px; text-transform: uppercase; font-style: italic;">'.$class->statusSecondQ.'</div></td>';
                    }
                }else{
                        $query .= '<td style="width: 10% !important; text-align:center;"><input id="secondQ" class="form-control" name="secondQ[]" type="number" step="0.01" hidden></td>';
                }
                if($class->thirdQ != null){
                    $query .= '<td style="width: 10% !important; text-align:center;"><input id="thirdQ" value="'. $class->thirdQ .'" class="form-control" name="thirdQ[]" hidden><strong style="font-size:14px; color:#05300e">'.$class->thirdQ.' % </strong>';
                    if($class->statusThirdQ == 'Pending'){
                        $query .='<div class="badge badge-warning" style="font-size:10px; text-transform: uppercase; font-style: italic;">'.$class->statusThirdQ.'</div></td>';
                    }else{
                        $query .='<div class="badge badge-success" style="font-size:10px; text-transform: uppercase; font-style: italic;">'.$class->statusThirdQ.'</div></td>';
                    }
                }else{
                        $query .= '<td style="width: 10% !important; text-align:center;"><input id="thirdQ" class="form-control" name="thirdQ[]" type="number" step="0.01" hidden></td>';
                }
                if($class->fourthQ != null){
                    $query .= '<td style="width: 10% !important; text-align:center;"><input id="fourthQ" value="'. $class->fourthQ .'" class="form-control" name="fourthQ[]" hidden><strong style="font-size:14px; color:#05300e">'.$class->fourthQ.' % </strong>';
                    if($class->statusFourthQ == 'Pending'){
                        $query .='<div class="badge badge-warning" style="font-size:10px; text-transform: uppercase; font-style: italic;">'.$class->statusFourthQ.'</div></td>';
                    }else{
                        $query .='<div class="badge badge-success" style="font-size:10px; text-transform: uppercase; font-style: italic;">'.$class->statusFourthQ.'</div></td>';
                    }
                }else{
                        $query .= '<td style="width: 10% !important; text-align:center;"><input id="fourthQ" class="form-control" name="fourthQ[]" type="number" step="0.01" max="100" hidden></td>';
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
    public function validateGrades(Request $request){
        DB::beginTransaction();
        $subjectIds = $request->subj_id;
        $data = $request->all(); // Assuming this is an array of subject IDs
        foreach ($subjectIds as $key => $subjectId) {
            $grades = Grade::where('student_subject_id', $subjectId)->first();
            $grades->student_subject_id = $subjectId;
            $grades->grade_level = $request->glevel;
            $grades->firstQ = $data['firstQ'][$key];
            $grades->secondQ = $data['secondQ'][$key];
            $grades->thirdQ = $data['thirdQ'][$key];
            $grades->fourthQ = $data['fourthQ'][$key];
            $grades->cumulative_gpa = ($data['firstQ'][$key] + $data['secondQ'][$key] + $data['thirdQ'][$key] + $data['fourthQ'][$key])/4;
            if($data['firstQ'][$key] != null && $grades->date_approved_firstQ == null){
                $grades->statusFirstQ = 'Approved';
                $grades->date_approved_firstQ = date('Y-m-d H:i:s');
            }
            if($data['secondQ'][$key] != null && $grades->date_approved_secondQ == null){
                $grades->statusSecondQ = 'Approved';
                $grades->date_approved_secondQ = date('Y-m-d H:i:s');
            }
            if($data['thirdQ'][$key] != null && $grades->date_approved_thirdQ == null){
                $grades->statusThirdQ = 'Approved';
                $grades->date_approved_thirdQ = date('Y-m-d H:i:s');
            }
            if($data['fourthQ'][$key] != null && $grades->date_approved_fourthQ == null){
                $grades->statusFourthQ = 'Approved';
                $grades->date_approved_fourthQ = date('Y-m-d H:i:s');
            }
            $grades->update();
        }
        DB::commit();
        return response()->json([
            'status'=>'success'
        ]);
    }
}
