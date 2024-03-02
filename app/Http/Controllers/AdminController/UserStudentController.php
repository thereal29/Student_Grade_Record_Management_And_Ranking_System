<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserRoles;
use App\Models\User;
use App\Models\SchoolYear;
use App\Models\StudentUser;
use App\Models\GradeSection;
use App\Models\StudentUserMapping;
use App\Models\Subjects;
use App\Models\StudentSubjects;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;

class UserStudentController extends Controller
{
    public function index(){
        $schoolyear = SchoolYear::select('*')->groupBy('school_year.from_year')->get();
        return view('admin.modules.users.student.index', compact('schoolyear'));
    }
    public function fetchUser(Request $request){
        if($request->sy != null){
            $users = User::select('*', 'student_personal_details.id as sid', 'student_personal_details.firstname as sfname', 'student_personal_details.lastname as slname')->leftJoin('student_user_mapping', 'users.id', '=', 'student_user_mapping.user_id')->leftJoin('student_personal_details', 'student_personal_details.id', '=', 'student_user_mapping.student_id')->join('student_gradelevel_section', 'student_personal_details.glevel_section_id', '=', 'student_gradelevel_section.id')->join('school_year', 'school_year.id', '=', 'users.sy_id')->where('student_gradelevel_section.grade_level', $request->gradelevel)->where('school_year.from_year', $request->sy)->get();
        }
        else{
            $users = User::select('*', 'student_personal_details.id as sid', 'student_personal_details.firstname as sfname', 'student_personal_details.lastname as slname')->leftJoin('student_user_mapping', 'users.id', '=', 'student_user_mapping.user_id')->leftJoin('student_personal_details', 'student_personal_details.id', '=', 'student_user_mapping.student_id')->join('student_gradelevel_section', 'student_personal_details.glevel_section_id', '=', 'student_gradelevel_section.id')->where('student_gradelevel_section.grade_level', $request->gradelevel)->get();
        }
        $query = '<table class="table border-0 star-student table-hover table-center mb-0 datatables table-striped">
            <thead class="student-thread">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Grade & Section</th>
                    <th>Action</th>
                </tr>
            </thead>';
            foreach($users as $key=>$students){
                $query .= '<tr>
                <td>STD'.++$key.'</td>
                <td>'.$students->sfname.' '.$students->slname.'</td>
                <td>'.$students->gender.'</td>
                <td>'.$students->username.'</td>
                <td>'.$students->email.'</td>
                <td>'.$students->grade_level.' '.$students->section.'</td>
                <td class="text-end">
                    <div class="actions">
                        <a id="' . $students->sid . '" class="btn btn-sm bg-danger-light edit_student_user">
                            <i class="feather-edit"></i>
                        </a>
                        <a id="' . $students->sid . '" class="btn btn-sm bg-danger-light student_delete" data-bs-toggle="modal" data-bs-target="#studentUser">
                            <i class="fe fe-trash-2"></i>
                        </a>
                    </div>
                </td>
            </tr>';
            }
            $query .= '</tbody></table>';
        return response()->json([
            'status'=>'success',
            'query'=> $query
        ]);
    }
    public function add(){
        return view('admin.modules.users.student.add');
    }
    public function create(Request $request){
        $request->validate([
            'first_name'    => 'required|string',
            'middle_name'   => 'nullable|string',
            'last_name'     => 'required|string',
            'lrn_number'    => 'required|digits:12|unique:student_personal_details',
            'grade_level'   => 'required|not_in:0',
            'section'       => 'required|string',
            'gender'        => 'required|not_in:0',
            'email'         => 'required|email',
            'phone_number'  => 'nullable|digits:11',
        ]);
        DB::beginTransaction();
        try {
                $gradelevelID = GradeSection::select('id')->where('grade_level', $request->grade_level)->where('section', $request->section)->first();
                $currentSY = SchoolYear::where('isCurrent', 1)->first();
                $student = new StudentUser;
                $student->firstname = Str::title($request->first_name);
                $student->middlename = Str::title($request->middle_name);
                $student->lastname = Str::title($request->last_name);
                $student->lrn_number = $request->lrn_number;
                $student->glevel_section_id = $gradelevelID->id;
                $student->gender = $request->gender;
                $student->phone_number = $request->phone_number;
                $student->save();
                $studentUser = new User;
                $studentUser->email = $request->email;
                if($request->gender == 'Male'){
                    $studentUser->avatar = "default-male.png";
                }else{
                    $studentUser->avatar = "default-female.png";
                }
                $substr1 = Str::substr($request->first_name, 0, 3);
                $substr2 = Str::substr($request->lrn_number, 0, 4);
                $studentUser->username = Str::lower($substr1.''.$request->last_name);
                $pass = Str::lower($request->last_name).''.$substr2;
                $studentUser->password = Hash::make($pass);
                if($request->grade_level == 'Grade 7' || $request->grade_level == 'Grade 8' || $request->grade_level == 'Grade 9' || $request->grade_level == 'Grade 10'){
                    $studentUser->role = 6; 
                }else{
                    $studentUser->role = 7; 
                }
                $studentUser->sy_id = $currentSY->id;
                $studentUser->save();
                $mapping =  new StudentUserMapping;
                $mapping->student_id = $student->id;
                $mapping->user_id = $studentUser->id;
                $mapping->save();
                $subject = Subjects::select('*')->where('grade_level', $request->grade_level)->get();
                foreach($subject as $subjects){
                    $student_subject = new StudentSubjects;
                    $student_subject->subject_id = $subjects->id;
                    $student_subject->student_id = $student->id;
                    $student_subject->sy_id = $currentSY->id;
                    $student_subject->status = 'Initialized';
                    $student_subject->save();
                }
                Toastr::success('Has been added successfully :)','Success');
                DB::commit();
                return redirect()->route('admin.student-user');
        }catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Add new student  :)','Error');
            return redirect()->back();
        }
    }
    public function edit(Request $request){
        $studentID = $request->id;
        $student = $users = User::select('*', 'student_personal_details.id as sid', 'student_personal_details.firstname as sfname', 'student_personal_details.lastname as slname')->leftJoin('student_user_mapping', 'users.id', '=', 'student_user_mapping.user_id')->leftJoin('student_personal_details', 'student_personal_details.id', '=', 'student_user_mapping.student_id')->join('student_gradelevel_section', 'student_personal_details.glevel_section_id', '=', 'student_gradelevel_section.id')->where('student_personal_details.id', $studentID)->first();
        return response()->json($student);
    }
    public function update(Request $request){
        $request->validate([
            'first_name'    => 'required|string',
            'middle_name'   => 'nullable|string',
            'last_name'     => 'required|string',
            'lrn_number'    => 'required|digits:12|unique:student_personal_details,lrn_number,'.$request->student_id,
            'grade_level'   => 'required|not_in:0',
            'section'       => 'required|string',
            'gender'        => 'required|not_in:0',
            'email'         => 'required|email',
            'phone_number'  => 'nullable|digits:11',
        ]);
        DB::beginTransaction();
        $gradelevelID = GradeSection::select('id')->where('grade_level', $request->grade_level)->where('section', $request->section)->first();
        $student = StudentUser::find($request->student_id);
        $student->firstname = Str::title($request->first_name);
        $student->middlename = Str::title($request->middle_name);
        $student->lastname = Str::title($request->last_name);
        $student->lrn_number = $request->lrn_number;
        $student->glevel_section_id = $gradelevelID->id;
        $student->gender = $request->gender;
        $student->phone_number = $request->phone_number;
        $student->update();
        $studentUser = User::join('student_user_mapping', 'student_user_mapping.user_id', '=', 'users.id')->where('student_id', $student->id)->first();
        $studentUser->email = $request->email;
        if($request->gender == 'Male'){
            $studentUser->avatar = "default-male.png";
        }else{
            $studentUser->avatar = "default-female.png";
        }
        if($request->grade_level == 'Grade 7' || $request->grade_level == 'Grade 8' || $request->grade_level == 'Grade 9' || $request->grade_level == 'Grade 10'){
            $studentUser->role = 6; 
        }else{
            $studentUser->role = 7; 
        }
        $studentUser->update();
        DB::commit();
        return response()->json([
            'status'=>'success',
            'message'=>'Subject Updated Successfully.'
        ]);
    }
}
