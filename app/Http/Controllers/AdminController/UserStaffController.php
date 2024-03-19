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

class UserStaffController extends Controller
{
    public function index(){
        $schoolyear = SchoolYear::select('*')->groupBy('school_year.from_year')->get();
        return view('admin.modules.users.staff.index', compact('schoolyear'));
    }
    public function fetchUser(Request $request){
        if($request->sy == null || $request->sy == 'showall'){
            $users = User::select('*', 'faculty_staff_personal_details.id as fid', 'faculty_staff_personal_details.firstname as ffname', 'faculty_staff_personal_details.lastname as flname')->join('faculty_staff_user_mapping', 'users.id', '=', 'faculty_staff_user_mapping.user_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'faculty_staff_user_mapping.faculty_staff_id')->join('school_year', 'school_year.id', '=', 'users.sy_id')->join('user_roles', 'user_roles.id', '=', 'users.role')->where('users.role', $request->staffRole)->get();
        }
        else{
            $users = User::select('*', 'faculty_staff_personal_details.id as fid', 'faculty_staff_personal_details.firstname as ffname', 'faculty_staff_personal_details.lastname as flname')->join('faculty_staff_user_mapping', 'users.id', '=', 'faculty_staff_user_mapping.user_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'faculty_staff_user_mapping.faculty_staff_id')->join('school_year', 'school_year.id', '=', 'users.sy_id')->join('user_roles', 'user_roles.id', '=', 'users.role')->where('school_year.from_year', $request->sy)->where('users.role', $request->staffRole)->get();
        }
        $query = '<table class="table border-0 star-student table-hover table-center mb-0 datatables table-striped">
            <thead class="student-thread">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>';
            foreach($users as $key=>$staff){
                $query .= '<tr>
                <td>STAFF'.++$key.'</td>
                <td>'.$staff->ffname.' '.$staff->flname.'</td>
                <td>'.$staff->gender.'</td>
                <td>'.$staff->username.'</td>
                <td>'.$staff->email.'</td>
                <td>'.$staff->description.'</td>
                <td class="text-end">
                    <div class="actions">
                        <a id="' . $staff->fid . '" class="btn btn-sm bg-danger-light edit_staff_user">
                            <i class="feather-edit"></i>
                        </a>
                        <a id="' . $staff->fid . '" class="btn btn-sm bg-danger-light staff_delete" data-bs-toggle="modal" data-bs-target="#studentUser">
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
        return view('admin.modules.users.staff.add');
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
            'staff_role'  => 'required|not_in:0',
        ]);
        DB::beginTransaction();
        try { 
                $currentSY = SchoolYear::where('isCurrent', 1)->first();
                $staff = new FacultyStaff;
                $staff->firstname = Str::title($request->first_name);
                $staff->middlename = Str::title($request->middle_name);
                $staff->lastname = Str::title($request->last_name);
                $staff->university_number = $request->university_number;
                $staff->gender = $request->gender;
                $staff->phone_number = '63'.$request->phone_number;
                $staff->home_address = $request->home_address;
                $staff->save();
                $staffUser = new User;
                $staffUser->email = $request->email;
                if($request->gender == 'Male'){
                    $staffUser->avatar = "admin-male.png";
                }else{
                    $staffUser->avatar = "admin-female.png";
                }
                $substr1 = Str::substr($request->first_name, 0, 3);
                $substr2 = Str::substr($request->university_number, 0, 4);
                $staffUser->username = Str::lower($substr1.''.$request->last_name);
                $pass = Str::lower($request->last_name).''.$substr2;
                $staffUser->password = Hash::make($pass);
                $staffUser->role = $request->staff_role;
                $staffUser->sy_id = $currentSY->id;
                $staffUser->save();
                $mapping =  new FacultyStaffUserMapping;
                $mapping->faculty_staff_id = $staff->id;
                $mapping->user_id = $staffUser->id;
                $mapping->save();
                Toastr::success('Has been added successfully :)','Success');
                DB::commit();
                return redirect()->route('admin.staff-user');
        }catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Add new student  :)','Error');
            return redirect()->back();
        }
    }
    public function edit(Request $request){
        $staffID = $request->id;
        $staff = FacultyStaff::select('*', 'faculty_staff_personal_details.id as fid', 'faculty_staff_personal_details.firstname as ffname', 'faculty_staff_personal_details.lastname as flname')->join('faculty_staff_user_mapping', 'faculty_staff_user_mapping.faculty_staff_id', '=', 'faculty_staff_personal_details.id')->join('users', 'users.id', '=', 'faculty_staff_user_mapping.user_id')->join('school_year', 'school_year.id', '=', 'users.sy_id')->join('user_roles', 'user_roles.id', '=', 'users.role')->where('faculty_staff_personal_details.id', $staffID)->first();
        return response()->json($staff);
    }
    public function update(Request $request){
        $id = $request->id;
        $request->validate([
            'first_name'    => 'required|string',
            'middle_name'   => 'nullable|string',
            'last_name'     => 'required|string',
            'university_number'    => 'required|digits:12|unique:faculty_staff_personal_details,university_number,'.$request->staff_id,
            'gender'        => 'required|not_in:0',
            'email'         => 'required|email',
            'phone_number'  => 'required|digits:12',
            'home_address'  => 'required|string',
            'staff_role'  => 'required|not_in:0',
        ]);
        $staff = FacultyStaff::find($request->staff_id);
        $staff->firstname = Str::title($request->first_name);
        $staff->middlename = Str::title($request->middle_name);
        $staff->lastname = Str::title($request->last_name);
        $staff->university_number = $request->university_number;
        $staff->gender = $request->gender;
        $staff->phone_number = $request->phone_number;
        $staff->home_address = $request->home_address;
        $staff->update();
        $staffUser = User::join('faculty_staff_user_mapping', 'faculty_staff_user_mapping.user_id', '=', 'users.id')->where('faculty_staff_id', $staff->id)->first();
        $staffUser->email = $request->email;
        if($request->gender == 'Male'){
            $staffUser->avatar = "admin-male.png";
        }else{
            $staffUser->avatar = "admin-female.png";
        }
        $staffUser->role = $request->staff_role;
        $staffUser->update();
        return response()->json([
            'status'=>'success',
            'message'=>'Subject Updated Successfully.'
        ]);
    }
}
