<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\UserRoles;
use App\Models\User;
use App\Models\SchoolYear;
class UserController extends Controller
{
    public function maincontent(){

        $SY = SchoolYear::all();
        return view('admin.modules.', compact('users'));
    }
    public function filterRoles(Request $request){
        $roles = UserRoles::all();
        if($request->role != null){
            $users = DB::table('users')->leftJoin('student_user_mapping', 'users.id', '=', 'student_user_mapping.user_id')->leftJoin('student_personal_details', 'student_personal_details.id', '=', 'student_user_mapping.student_id')->leftJoin('faculty_staff_user_mapping', 'users.id', '=', 'faculty_staff_user_mapping.user_id')->leftJoin('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'faculty_staff_user_mapping.faculty_staff_id')->where('users.role', $request->role)->select('*', 'users.id AS ctr', DB::raw('coalesce(student_personal_details.firstname, faculty_staff_personal_details.firstname) AS fname, SUBSTRING(coalesce(student_personal_details.middlename, faculty_staff_personal_details.middlename) ,1,1) AS minit, coalesce(student_personal_details.middlename, faculty_staff_personal_details.middlename) as mname, coalesce(student_personal_details.lastname, faculty_staff_personal_details.lastname) AS lname'))->get();
        }
        else{
            //, 'student_personal_details.firstname AS sfname', 'student_personal_details.middlename AS smname', 'student_personal_details.lastname AS slname', 'faculty_staff_personal_details.firstname AS ffname', 'faculty_staff_personal_details.middlename AS fmname', 'faculty_staff_personal_details.lastname AS flname'
            $users = DB::table('users')->leftJoin('student_user_mapping', 'users.id', '=', 'student_user_mapping.user_id')->leftJoin('student_personal_details', 'student_personal_details.id', '=', 'student_user_mapping.student_id')->leftJoin('faculty_staff_user_mapping', 'users.id', '=', 'faculty_staff_user_mapping.user_id')->leftJoin('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'faculty_staff_user_mapping.faculty_staff_id')->select('*', 'users.id AS ctr', DB::raw('coalesce(student_personal_details.firstname, faculty_staff_personal_details.firstname) AS fname, SUBSTRING(coalesce(student_personal_details.middlename, faculty_staff_personal_details.middlename) ,1,1) AS minit, coalesce(student_personal_details.middlename, faculty_staff_personal_details.middlename) as mname, coalesce(student_personal_details.lastname, faculty_staff_personal_details.lastname) AS lname'))->get();
        }
        // $users = User::when($request->role != null, function ($q) use ($request){
        //     return $q->where('role', $request->role);
        // })
        // ->paginate(10);     

        // if($request->ajax()){
        //    $users = $query->where(['role'=>$request->roles])->get();
        //     return response()->json(['users'=>$users]);
        // }
        // $users = $query->get();
        return view('admin.users_list', compact('roles', 'users'));
    }
    public function viewProfile(Request $request){
        $user_id = $request->id;
        $user_role = DB::table('user_roles')->select('user_roles.id')->join('users', 'users.role', '=', 'user_roles.id')->where('users.id', $user_id)->first();
        if(($user_role->id == '6') || ($user_role->id == '7') || ($user_role->id == '8') || ($user_role->id == '9')){
            $details = DB::table('student_personal_details')->join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->where('users.id', $user_id)->first();
        }else{
            $details = DB::table('faculty_staff_personal_details')->join('faculty_staff_user_mapping', 'faculty_staff_user_mapping.faculty_staff_id', '=', 'faculty_staff_personal_details.id')->join('users', 'users.id', '=', 'faculty_staff_user_mapping.user_id')->join('user_roles', 'user_roles.id', '=', 'users.role')->where('users.id', $user_id)->first();
        }
        return view('admin.user_view', compact('details', 'user_id', 'user_role'));
    }
}
