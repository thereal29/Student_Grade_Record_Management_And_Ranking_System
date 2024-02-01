<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserRoles;
class SettingsController extends Controller
{
    public function maincontent(){
        return view('admin.modules.settings.index', ["msg"=>"This is report page"]);
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
        return view('admin.settings_user_accounts', compact('roles', 'users'));
    }
}
