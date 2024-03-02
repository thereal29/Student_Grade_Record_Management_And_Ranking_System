<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentUser;
use App\Models\Subjects;
use App\Models\Curriculum;
use App\Models\CurriculumGrades;
use Illuminate\Support\Facades\DB;
class SubjectController extends Controller
{
    public function index(){
        return view('admin.modules.subjects.index');
    }
    public function fetchSubjects(Request $request){
        $gradelevel = $request->gradelevel;
        if($gradelevel != null){
            $subjects = Subjects::select('*','subject.id as sid')->leftJoin('student_subject', 'student_subject.subject_id', 'subject.id')->leftJoin('class', 'class.student_subject_id', '=', 'student_subject.id')->leftJoin('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->where('grade_level', $gradelevel)->get();
        }else{
            $subjects = Subjects::select('*','subject.id as sid')->leftJoin('student_subject', 'student_subject.subject_id', 'subject.id')->leftJoin('class', 'class.student_subject_id', '=', 'student_subject.id')->leftJoin('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->get();
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
                                <a id="'.$subject->sid.'" class="btn btn-sm bg-danger-light">
                                    <i class="feather-edit"></i>
                                </a>
                                <a id="'.$subject->sid.'" class="btn btn-sm bg-danger-light delete_subject">
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
        $curriculum = new Curriculum;
        $curriculum->subject_code = $request->subjectcode;
        $curriculum->subject_description = $request->subjectdesc;
        $curriculum->credits = $request->credits;
        $curriculum->grade_level = $request->gradelevel;
        $curriculum->save();
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
        $subject = Subjects::find($id);
        return response()->json($subject);
    }
    public function update(Request $request){
        $id = $request->id;
        $curriculum = Subjects::find($request->cur_id);
        $curriculum->subject_code = $request->subjectcode;
        $curriculum->subject_description = $request->subjectdesc;
        $curriculum->credits = $request->credits;
        $curriculum->grade_level = $request->editgradelevel;
        $curriculum->update();
        return response()->json([
            'status'=>'success',
            'message'=>'Subject Updated Successfully.'
        ]);
    }
}
