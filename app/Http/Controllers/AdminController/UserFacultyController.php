<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserRoles;
use App\Models\User;
use App\Models\SchoolYear;
use App\Models\ClassAdvisory;
use App\Models\Classes;
use App\Models\FacultyStaff;
use App\Models\FacultyStaffUserMapping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;

class UserFacultyController extends Controller
{
    public function index(){
        $schoolyear = SchoolYear::select('*')->groupBy('school_year.from_year')->get();
        return view('admin.modules.users.faculty.index', compact('schoolyear'));
    }
    public function fetchUser(Request $request){
        if($request->sy == null || $request->sy == 'showall'){
            $users = User::select('*', 'faculty_staff_personal_details.id as fid', 'faculty_staff_personal_details.firstname as ffname', 'faculty_staff_personal_details.lastname as flname')->join('faculty_staff_user_mapping', 'users.id', '=', 'faculty_staff_user_mapping.user_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'faculty_staff_user_mapping.faculty_staff_id')->join('school_year', 'school_year.id', '=', 'users.sy_id')->where('users.role', 5)->get();
        }
        else{
            $users = User::select('*', 'faculty_staff_personal_details.id as fid', 'faculty_staff_personal_details.firstname as ffname', 'faculty_staff_personal_details.lastname as flname')->join('faculty_staff_user_mapping', 'users.id', '=', 'faculty_staff_user_mapping.user_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'faculty_staff_user_mapping.faculty_staff_id')->join('school_year', 'school_year.id', '=', 'users.sy_id')->where('users.role', 5)->where('school_year.from_year', $request->sy)->get();
        }
            $query = '<table class="table border-0 star-student table-hover table-center mb-0 datatables table-striped">
            <thead class="student-thread">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Faculty Description</th>
                    <th>Action</th>
                </tr>
            </thead>';
            foreach($users as $key=>$faculty){
                $adviser = ClassAdvisory::where('faculty_id', $faculty->fid)->get();
                $subjTeacher = Classes::where('faculty_id', $faculty->fid)->get();
                $query .= '<tr>
                <td>FCLTY'.++$key.'</td>
                <td>'.$faculty->ffname.' '.$faculty->flname.'</td>
                <td>'.$faculty->gender.'</td>
                <td>'.$faculty->username.'</td>
                <td>'.$faculty->email.'</td>';
                if($adviser->count() != 0 && $subjTeacher->count() != 0){
                    $query.= '<td>Subject Teacher and Class Adviser</td>';
                }elseif ($adviser->count() != 0 && $subjTeacher->count() == 0) {
                    $query.= '<td>Class Adviser</td>';
                }elseif ($adviser->count() == 0 && $subjTeacher->count() != 0) {
                    $query.= '<td>Subject Teacher</td>';
                }else{
                    $query.= '<td>None</td>';
                }
                $query .='<td class="text-end">
                    <div class="actions">
                        <a id="' . $faculty->fid . '" class="btn btn-sm bg-danger-light edit_faculty_user">
                            <i class="feather-edit"></i>
                        </a>
                        <a id="' . $faculty->fid . '" class="btn btn-sm bg-danger-light faculty_delete" data-bs-toggle="modal" data-bs-target="#studentUser">
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
        return view('admin.modules.users.faculty.add');
    }
    public function create(Request $request){
        $request->validate([
            'first_name'    => 'required|string',
            'middle_name'   => 'nullable|string',
            'last_name'     => 'required|string',
            'university_number'    => 'required|digits:12|unique:faculty_staff_personal_details',
            'gender'        => 'required|not_in:0',
            'email'         => 'required|email',
            'phone_number'  => 'required|digits:10',
            'home_address'  => 'required|string',
        ]);
        DB::beginTransaction();
        try { 
                $currentSY = SchoolYear::where('isCurrent', 1)->first();
                $faculty = new FacultyStaff;
                $faculty->firstname = Str::title($request->first_name);
                $faculty->middlename =Str::title( $request->middle_name);
                $faculty->lastname = Str::title($request->last_name);
                $faculty->university_number = $request->university_number;
                $faculty->gender = $request->gender;
                $faculty->phone_number = '63'.$request->phone_number;
                $faculty->home_address = $request->home_address;
                $faculty->save();
                $facultyUser = new User;
                $facultyUser->email = $request->email;
                if($request->gender == 'Male'){
                    $facultyUser->avatar = "faculty-male.png";
                }else{
                    $facultyUser->avatar = "faculty-female.png";
                }
                $substr1 = Str::substr($request->first_name, 0, 3);
                $substr2 = Str::substr($request->university_number, 0, 4);
                $facultyUser->username = Str::lower($substr1.''.$request->last_name);
                $pass = Str::lower($request->last_name).''.$substr2;
                $facultyUser->password = Hash::make($pass);
                $facultyUser->role = 5;
                $facultyUser->sy_id = $currentSY->id;
                $facultyUser->save();
                $mapping =  new FacultyStaffUserMapping;
                $mapping->faculty_staff_id = $faculty->id;
                $mapping->user_id = $facultyUser->id;
                $mapping->save();
                Toastr::success('Has been added successfully :)','Success');
                DB::commit();
                return redirect()->route('admin.faculty-user');
        }catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Add new student  :)','Error');
            return redirect()->back();
        }
    }
    public function edit(Request $request){
        $facultyID = $request->id;
        $faculty = FacultyStaff::select('*', 'faculty_staff_personal_details.id as fid', 'faculty_staff_personal_details.firstname as ffname', 'faculty_staff_personal_details.lastname as flname')->join('faculty_staff_user_mapping', 'faculty_staff_user_mapping.faculty_staff_id', '=', 'faculty_staff_personal_details.id')->join('users', 'users.id', '=', 'faculty_staff_user_mapping.user_id')->join('school_year', 'school_year.id', '=', 'users.sy_id')->join('user_roles', 'user_roles.id', '=', 'users.role')->where('faculty_staff_personal_details.id', $facultyID)->first();
        return response()->json($faculty);
    }
    public function update(Request $request){
        $id = $request->id;
        $request->validate([
            'first_name'    => 'required|string',
            'middle_name'   => 'nullable|string',
            'last_name'     => 'required|string',
            'university_number'    => 'required|digits:12|unique:faculty_staff_personal_details,university_number,'.$request->faculty_id,
            'gender'        => 'required|not_in:0',
            'email'         => 'required|email',
            'phone_number'  => 'required|digits:12',
            'home_address'  => 'required|string',
        ]);
        $faculty = FacultyStaff::find($request->faculty_id);
        $faculty->firstname = Str::title($request->first_name);
        $faculty->middlename = Str::title($request->middle_name);
        $faculty->lastname = Str::title($request->last_name);
        $faculty->university_number = $request->university_number;
        $faculty->gender = $request->gender;
        $faculty->phone_number = $request->phone_number;
        $faculty->home_address = $request->home_address;
        $faculty->update();
        $facultyUser = User::join('faculty_staff_user_mapping', 'faculty_staff_user_mapping.user_id', '=', 'users.id')->where('faculty_staff_id', $faculty->id)->first();
        $facultyUser->email = $request->email;
        if($request->gender == 'Male'){
            $facultyUser->avatar = "faculty-male.png";
        }else{
            $facultyUser->avatar = "faculty-female.png";
        }
        $facultyUser->update();
        return response()->json([
            'status'=>'success',
            'message'=>'Subject Updated Successfully.'
        ]);
    }
}
