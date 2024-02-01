<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FacultyStaff;
use App\Models\Classes;
use App\Models\ClassAdvisory;
use App\Models\StudentUser;
use Illuminate\Support\Facades\DB;
class FacultyController extends Controller
{
    public function index(){
        $selSY = \Session::get('fromSY');
        $faculties = FacultyStaff::select('*', 'faculty_staff_personal_details.id as fid','class.id as cid', 'class_advisory.id as caid', DB::raw('COUNT(class.id) AS ctr'))->join('class', 'class.faculty_id', '=', 'faculty_staff_personal_details.id')->leftJoin('class_advisory', 'class_advisory.faculty_id', '=', 'faculty_staff_personal_details.id')->join('student_subject', 'student_subject.id', '=', 'class.student_subject_id')->join('subject', 'subject.id', '=', 'student_subject.subject_id')->leftJoin('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'class_advisory.glevel_section_id')->join('faculty_staff_user_mapping', 'faculty_staff_user_mapping.faculty_staff_id', '=', 'faculty_staff_personal_details.id')->join('users', 'users.id', '=', 'faculty_staff_user_mapping.user_id')->join('school_year', 'school_year.id', '=', 'users.sy_id')->groupBy('class.faculty_id')->where('school_year.from_year', $selSY)->get();
        return view('admin.modules.faculty.index', compact('faculties'));
    }
    public function viewFacData(Request $request){
        $details = FacultyStaff::join('faculty_staff_user_mapping', 'faculty_staff_user_mapping.faculty_staff_id', '=', 'faculty_staff_personal_details.id')->join('users', 'users.id', '=', 'faculty_staff_user_mapping.user_id')->join('user_roles', 'user_roles.id', '=', 'users.role')->where('users.id', $request->id)->first();
        return view('admin.modules.faculty.view_faculty', compact('details'));
    }
    public function viewClass(Request $request){
        $name = FacultyStaff::select('*', 'faculty_staff_personal_details.id as fid', 'faculty_staff_personal_details.firstname as ffname', 'faculty_staff_personal_details.lastname as flname')->where('faculty_staff_personal_details.id', $request->id)->first();
        return view('admin.modules.faculty.view_load', compact('name'));
    }
    public function fetchClass(Request $request){
        $gradelevel = $request->gradelevel;
        $faculty_id = $request->faculty_id;
        if($gradelevel != null && $gradelevel != 'showall' ){
            $classes = DB::table('class')->select('*', 'class.id as cid','subject.grade_level AS class_glevel', DB::raw('COUNT(student_personal_details.id) AS ctr'))->join('student_subject', 'student_subject.id', '=', 'class.student_subject_id')->join('subject', 'subject.id', '=', 'student_subject.subject_id')->join('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->where('class.faculty_id', $faculty_id)->where('subject.grade_level', $gradelevel)->groupBy('class.student_subject_id')->get();
        }else{
            $classes = DB::table('class')->select('*', 'class.id as cid','subject.grade_level AS class_glevel', DB::raw('COUNT(student_personal_details.id) AS ctr'))->join('student_subject', 'student_subject.id', '=', 'class.student_subject_id')->join('subject', 'subject.id', '=', 'student_subject.subject_id')->join('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->where('class.faculty_id', $faculty_id)->groupBy('class.student_subject_id')->get();
        }
        $query = '';
        $c =$classes->count();
        if($classes->count() > 0){
            $query .= '<table id="tableData" class="table table-bordered table-striped display responsive nowrap" style="width:100%">
            <thead id="column_name" class="table-dark">
                <tr>
                    <th style="font-size:14px; font-weight:bold; text-align:center;">No.</th>
                    <th style="font-size:14px; font-weight:bold; text-align:center;">Subject Code</th>
                    <th style="font-size:14px; font-weight:bold; text-align:center;">Subject Description</th>
                    <th style="font-size:14px; font-weight:bold; text-align:center;">Grade Level</th>
                    <th style="font-size:14px; font-weight:bold; text-align:center;">No. of Students</th>

                </tr>
            </thead>
            <tbody id="row_data">';
            $ctr = 1;
            foreach($classes as $class){
                $query .= '<tr>
                    <td>'. $ctr .'</td>
                    <td>'. $class->subject_code .'</td>
                    <td>'. $class->subject_description .'</td>
                    <td>'. $class->class_glevel .'</td>';
                    if($class->ctr != 0){
                        $query .= '<td text-align: center;"><a id="studLink" href="view=student?id='.$class->cid.'">'.$class->ctr; 
                        if($class->ctr > 1){
                            $query .= 'Students</a></td>';
                        }else{
                            $query .= 'Student</a></td>';
                        }
                    }else{
                        $query .= '<td>'.$class->ctr.' Student</td>';
                    }
                    $query .= '</tr>';
                $ctr++;
            }
                $query .= '</tbody></table>';
            }else{
                $query = '<h5 class="text-center text-secondary my-5">No record in the database!</h5>';
            }
            return response()->json([
                'status'=>'success',
                'query'=> $query,
                'gradelevel' => $gradelevel,
                'ctr'=> $classes
            ]);
    }
    public function viewStud(Request $request){
        $class = Classes::select('*', 'subject.grade_level AS class_glevel', 'class.student_subject_id as cid', 'faculty_staff_personal_details.firstname as ffname', 'faculty_staff_personal_details.lastname as flname', 'faculty_staff_personal_details.id as fid', DB::raw('COUNT(student_personal_details.id) AS ctr'))->join('student_subject', 'student_subject.id', '=', 'class.student_subject_id')->join('subject', 'subject.id', '=', 'student_subject.subject_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->join('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->where('class.id', $request->id)->first();
        $students = StudentUser::select('*', 'student_personal_details.firstname AS sfname', 'student_personal_details.lastname AS slname', 'student_personal_details.gender AS sgender','student_gradelevel_section.grade_level as glevel')->join('student_subject', 'student_subject.student_id', '=', 'student_personal_details.id')->join('subject', 'subject.id', '=', 'student_subject.subject_id')->join('class', 'class.student_subject_id', '=', 'student_subject.id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->where('class.id', $request->id)->get();
        return view('admin.modules.faculty.view_student', compact('class', 'students'));
    }
    public function viewAdvisory(Request $request){
        $class = ClassAdvisory::select('*', 'faculty_staff_personal_details.firstname as ffname', 'faculty_staff_personal_details.lastname as flname', DB::raw('COUNT(student_personal_details.id) AS ctr'))->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class_advisory.faculty_id')->join('student_personal_details', 'student_personal_details.glevel_section_id', '=', 'class_advisory.glevel_section_id')->where('class_advisory.id', $request->id)->first();
        $students = StudentUser::select('*', 'student_personal_details.firstname AS sfname', 'student_personal_details.lastname AS slname', 'student_personal_details.gender AS sgender','student_gradelevel_section.grade_level as glevel')->join('class_advisory', 'class_advisory.glevel_section_id', '=', 'student_personal_details.glevel_section_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class_advisory.faculty_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->where('class_advisory.id', $request->id)->get();
        return view('admin.modules.faculty.view_advisory', compact('class', 'students'));
    }
}
