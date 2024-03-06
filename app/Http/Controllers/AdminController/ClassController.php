<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentUser;
use App\Models\Subjects;
use App\Models\Classes;
use App\Models\Curriculum;
use App\Models\SchoolYear;
use App\Models\CurriculumGrades;
use App\Models\StudentSubjects;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
class ClassController extends Controller
{
    public function index(){
        return view('admin.modules.other_list.class.index');
    }
    public function fetchSubjects(Request $request){
        $gradelevel = $request->gradelevel;
        if($gradelevel != null){
            $subjects = Subjects::select('*','subject.id as sid')->leftJoin('student_subject', 'student_subject.subject_id', 'subject.id')->leftJoin('class', 'class.subject_id', '=', 'subject.id')->leftJoin('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->groupBy('subject.id')->where('grade_level', $gradelevel)->get();
        }else{
            $subjects = Subjects::select('*','subject.id as sid')->leftJoin('student_subject', 'student_subject.subject_id', 'subject.id')->leftJoin('class', 'class.subject_id', '=', 'subject.id')->leftJoin('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->groupBy('subject.id')->get();
        } 
        
        $query = '';
        if($subjects->count() >0){
            $query = '<table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
            <thead class="student-thread">
            <tr>
                <th>Subject Code</th>
                <th>Course Description</th>
                <th>Teacher</th>
                <th>Credits</th>
                <th>Students Enrolled</th>
                <th class="text-end">Action</th>
            </tr>
            </thead>
            <tbody>';
            foreach ($subjects as $subject){
                if($gradelevel != null){
                    $tempQ = DB::table('subject')->join('student_subject', 'student_subject.subject_id', '=', 'subject.id')->join('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->select('*','subject.id as sid', DB::raw('count(student_subject.student_id) AS totalstudents'))->groupBy('subject.id')->where('subject.grade_level', $gradelevel)->where('subject.id', $subject->sid)->first();
                }else{
                    $tempQ = DB::table('subject')->join('student_subject', 'student_subject.subject_id', '=', 'subject.id')->join('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->select('*','subject.id as sid', DB::raw('count(student_subject.student_id) AS totalstudents'))->groupBy('subject.id')->where('subject.grade_level', $gradelevel)->orwhere('subject.id', $subject->sid)->first();
                }
                $totalStud = $tempQ ? $tempQ->totalstudents : '';
                $query .= '<tr>
                    <td>'. $subject->subject_code .'</td>
                    <td>'. $subject->subject_description .'</td>';
                    if($subject->firstname != null){
                        $query .= '<td>'. $subject->firstname.' '.$subject->lastname.'</td>';
                    }else{
                        $query .= '<td>None</td>';
                    }
                    $query .= '<td>'. $subject->credits .'</td>
                    <td>'. $totalStud;
                        if($totalStud != null){
                            if($totalStud > 1){
                                $query .= ' students</td>';
                            }else{
                                $query .= ' student</td>';
                            }
                        }else{
                            $query .= '0 student</td>';
                        }
             $query .= '<td class="text-end">
                            <div class="actions">
                                <a id="'.$subject->sid.'" value="'.$totalStud.'" title="Assign Faculty" class="btn btn-sm bg-danger-light edit_subject">
                                    <i class="feather-edit"></i>
                                </a>
                                <a id="'.$subject->sid.'" title="Delete Faculty" class="btn btn-sm bg-danger-light delete_subject">
                                    <i class="fe fe-trash-2"></i>
                                </a>
                            </div>
                        </td>
                </tr>';
            }
            $query .='</tbody></table>';
        }else{
            $query = '<h1 class="text-center text-secondary my-5">No record in the database!</h1>';
        }
        return response()->json([
            'status'=>'success',
            'query'=> $query,
            'gradelevel' => $gradelevel,
            'subject' => $subjects
        ]);
    }
    public function store(Request $request){
        $currentSY = SchoolYear::where('isCurrent', 1)->first();
        $subject = new Subjects;
        $subject->subject_code = $request->subjectcode;
        $subject->subject_description = $request->subjectdesc;
        $subject->credits = $request->credits;
        $subject->grade_level = $request->gradelevel;
        $subject->save();
        $class = new Classes;
        $class->subject_id = $subject->id;
        $class->faculty_id = $request->faculty;
        $class->sy_id = $currentSY->id;
        $class->save();
        return response()->json([
            'status'=>'success',
            'message'=>'Subject Added Successfully.'
        ]);
    }
    public function delete(Request $request) {
        $id = $request->id;
        $subject = Subjects::find($id);
        Subjects::destroy($id);
    }
    public function edit(Request $request){
        $id = $request->id;
        $subject = Subjects::select('*', 'subject.id as sid', 'faculty_staff_personal_details.id as fid')->leftJoin('student_subject', 'student_subject.subject_id', '=', 'subject.id')->leftJoin('class', 'class.subject_id', '=', 'subject.id')->leftJoin('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->where('subject.id', $id)->first();
        return response()->json($subject);
    }
    public function update(Request $request){
        $request->validate([
            'subject_code'   => 'required|string',
            'subject_description'   => 'required|string',
            'credits'   => 'required|numeric|between:0,99.99',
            'grade_level'   => 'required|not_in:0',
            'faculty' => 'required|not_in:0',
        ]);
        DB::beginTransaction();
            $id = $request->id;
            $currentSY = SchoolYear::where('isCurrent', 1)->first();
            $subject = Subjects::find($request->cur_id);
            $subject->subject_code = $request->subject_code;
            $subject->subject_description = $request->subject_description;
            $subject->credits = $request->credits;
            $subject->grade_level = $request->grade_level;
            $subject->update();
            $classCTR = Classes::where('class.subject_id', $request->cur_id)->count();
            if($classCTR){
                $class = Classes::where('class.subject_id', $request->cur_id)->first();
                $class->subject_id = $request->cur_id;
                $class->faculty_id = $request->faculty;
                $class->sy_id = $currentSY->id;
                $class->update();
            }else{
                $class = new Classes;
                $class->subject_id = $request->cur_id;
                $class->faculty_id = $request->faculty;
                $class->sy_id = $currentSY->id;
                $class->save();
            }
            DB::commit();
            return response()->json([
                'status'=>'success',
                'message'=>'Subject Updated Successfully.'
            ]);
    }
}
