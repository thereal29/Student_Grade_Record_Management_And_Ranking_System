<?php

namespace App\Http\Controllers\TeacherController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\FacultyStaff;
use App\Models\Classes;
use App\Models\Grade;
use App\Models\StudentUser;

class ClassController extends Controller
{
    public function index(){
        $user_id = auth()->user()->id;
        $selSY = \Session::get('fromSY');
        $classes = DB::table('class')->select('*', 'class.id as cid','subject.grade_level AS class_glevel', DB::raw('COUNT(student_personal_details.id) AS ctr'))->join('student_subject', 'student_subject.id', '=', 'class.student_subject_id')->join('subject', 'subject.id', '=', 'student_subject.subject_id')->join('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->join('school_year', 'school_year.id', '=', 'class.sy_id')->where('class.faculty_id', $user_id)->where('school_year.from_year', $selSY)->groupBy('class.student_subject_id')->get();
        return view('teacher.modules.class.index', compact('classes'));
    }
    public function viewStudent(Request $request){
        $class = Classes::select('*', 'subject.grade_level AS class_glevel', 'class.id as cid', 'faculty_staff_personal_details.firstname as ffname', 'faculty_staff_personal_details.lastname as flname', DB::raw('COUNT(student_personal_details.id) AS ctr'))->join('student_subject', 'student_subject.id', '=', 'class.student_subject_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->join('subject', 'subject.id', '=', 'student_subject.subject_id')->join('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->where('class.id', $request->id)->first();
        $students = StudentUser::select('*', 'student_personal_details.id AS sid', 'student_personal_details.firstname AS sfname', 'student_personal_details.lastname AS slname', 'student_personal_details.gender AS sgender')->join('student_subject', 'student_subject.student_id', '=', 'student_personal_details.id')->join('class', 'class.student_subject_id', '=', 'student_subject.id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->join('subject', 'subject.id', '=', 'student_subject.subject_id')->leftJoin('grades_per_subject', 'grades_per_subject.student_subject_id', '=', 'student_subject.id')->where('class.id', $request->id)->get();

        foreach($students as $student){
        $final_rating = ($student->firstQ + $student->secondQ + $student->thirdQ + $student->fourthQ)/4 ;
        }

        return view('teacher.modules.class.view_student', compact('students', 'final_rating', 'class'));
    }
    public function viewStudGrade(Request $request){
        $student = StudentUser::select('*', 'student_personal_details.id AS sid','subject.id AS subid','school_year.id AS syid', 'grades_per_subject.id AS gid', 'student_personal_details.firstname AS sfname', 'student_personal_details.lastname AS slname', 'student_personal_details.gender AS sgender')->join('student_subject', 'student_subject.student_id', '=', 'student_personal_details.id')->join('class', 'class.id', '=', 'student_subject.class_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->join('subject', 'subject.id', '=', 'class.subject_id')->join('grades_per_subject', 'grades_per_subject.student_id', '=', 'student_personal_details.id')->join('school_year', 'school_year.id', '=', 'grades_per_subject.sy_id')->where('student_personal_details.id', $request->id)->first();
        $final_rating = ($student->firstQ + $student->secondQ + $student->thirdQ + $student->fourthQ)/4 ;
        return view('teacher.modules.class.view_grade', compact('student', 'final_rating'));
    }
    public function editGrade(Request $request, $id){
        $grade = Grade::findOrfail($id);
        $grade->student_id = $request->sid;
        $grade->subject_id = $request->subid;
        $class = Classes::select('*', 'subject.grade_level AS class_glevel', 'class.id as cid', 'faculty_staff_personal_details.firstname as ffname', 'faculty_staff_personal_details.lastname as flname', DB::raw('COUNT(student_personal_details.id) AS ctr'))->join('subject', 'subject.id', '=', 'class.subject_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->join('student_subject', 'student_subject.class_id', '=', 'class.id')->join('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->where('class.subject_id', $request->subid)->first();
        $grade->sy_id = $request->syid;
        $grade->firstQ = $request->first;
        $grade->secondQ = $request->second;
        $grade->thirdQ = $request->third;
        $grade->fourthQ = $request->fourth;
        $grade->save();

        Alert::success('Updated Successfully', 'Student Grade is Updated');
        return redirect()->route('teacher.student_view', ['id' => $class]);
    }
}
