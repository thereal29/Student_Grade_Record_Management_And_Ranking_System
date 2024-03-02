<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentUser;
use App\Models\Subjects;
use Illuminate\Support\Facades\DB;

class StudentRegistrationController extends Controller
{
    
    public function index(){
        return view('admin.modules.students.subjects.index');
    }
    public function fetchStudentRegistration(Request $request){
        $gradelevel = $request->gradelevel;
        $selSY = \Session::get('fromSY');
        if($gradelevel != null){
            $student = StudentUser::select('*','student_personal_details.id as sid', DB::raw('COUNT(student_subject.student_id) AS ctr'))->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->join('school_year', 'school_year.id', '=', 'users.sy_id')->leftJoin('student_subject', 'student_subject.student_id', '=', 'student_personal_details.id')->where('student_gradelevel_section.grade_level', $gradelevel)->where('school_year.from_year', $selSY)->groupBy('student_subject.subject_id')->get();
        }else{
            $student = StudentUser::select('*','student_personal_details.id as sid', DB::raw('COUNT(student_subject.student_id) AS ctr'))->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->join('school_year', 'school_year.id', '=', 'users.sy_id')->leftJoin('student_subject', 'student_subject.student_id', '=', 'student_personal_details.id')->where('school_year.from_year', $selSY)->groupBy('student_subject.subject_id')->get();
        }
        $query = '';
        if($student->count() > 0){
            $query .= '<table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
            <thead class="student-thread">
                <tr>
                    <th>LRN No.</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Grade & Section</th>
                    <th>Current Enrolled Subjects</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>';
            foreach($student as $students){
                $query .= ' <tr>
                <td>'.$students->lrn_number.'</td>
                <td>'.$students->firstname.' '.$students->lastname.'</td>
                <td>'.$students->gender.'</td>
                <td>'.$students->grade_level.' '.$students->section.'</td>
                <td style="text-align: center;"><div class="badge badge-info" style="font-size:12px;">'.$students->ctr;
                if($students->ctr != null){
                    if($students->ctr > 1){
                        $query .= ' subjects</div></td>';
                    }else{
                        $query .= ' subject</div></td>';
                    }
                }else{
                    $query .= ' subject</div></td>';
                }
                $query .= '<td><div class="badge badge-success" style="font-size:14px;">'.$students->status.'</div></td>
                <td class="text-end">
                    <div class="actions">
                        <a href="view=subject?id='.$students->sid.'" class="btn btn-sm bg-danger-light">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </td>
                </tr>';
            }
            $query .='</tbody></table>';
        }else{
            $query = '<h4 class="text-center text-secondary my-5">No data found!</h4>';
        }
        return response()->json([
            'status'=>'success',
            'query'=> $query,
            'gradelevel' => $gradelevel,
            'student' => $student->count()
        ]);
    }
    public function viewStudentSubjects(Request $request){
        $record = StudentUser::select('*','student_personal_details.id AS studID','student_personal_details.firstname AS fnameStud', 'student_personal_details.middlename AS mnameStud', 'student_personal_details.lastname AS lnameStud', 'subject.grade_level as sgrade_level')->leftJoin('student_subject', 'student_subject.student_id', '=', 'student_personal_details.id')->leftJoin('grades_per_subject', 'grades_per_subject.student_subject_id', '=', 'student_subject.id')->leftJoin('subject', 'subject.id', '=', 'student_subject.subject_id')->join('student_advisory', 'student_advisory.student_id', '=', 'student_personal_details.id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'student_advisory.adviser_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->where('student_personal_details.id', $request->id)->first();
        $subject = Subjects::select('*')->join('student_subject','student_subject.subject_id', '=', 'subject.id')->join('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->where('student_subject.student_id', $request->id)->get();
        return view('admin.modules.students.subjects.view_subject', compact('record', 'subject'));
    }
}
