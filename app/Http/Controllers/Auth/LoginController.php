<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Brian2694\Toastr\Facades\Toastr;
use Redirect;
use Session;
use Auth;
use DB;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;
use App\Models\FacultyStaff;
use App\Models\StudentUser;
use App\Models\ClassAdvisory;
use App\Models\Classes;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout',
            'locked',
            'unlock'
        ]);
    }
    public function login()
    {
        return view('auth.login');
    }
    // for login into different user roles
    public function authenticate(Request $request){
        $errors = new MessageBag; // initiate MessageBag
        $input = $request->all();
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required|min:8',
        ]);
        DB::beginTransaction();
        try {
                    $faculty = FacultyStaff::select('*', 'faculty_staff_personal_details.id as fid')->join('faculty_staff_user_mapping', 'faculty_staff_user_mapping.faculty_staff_id', '=', 'faculty_staff_personal_details.id')->join('users', 'users.id', '=', 'faculty_staff_user_mapping.user_id')->where('users.email', $input["email"])->first();
                    $facultyID = $faculty ?  $faculty->fid : 0; 
                    $student = StudentUser::select('*')->join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->where('users.email', $input["email"])->first();
                    $class_advisoryCTR = ClassAdvisory::where('faculty_id', $facultyID)->count();
                    if(auth()->attempt(['email'=>$input["email"], 'password'=>$input["password"]])){
                    if(auth()->user()->role == 'Super Administrator' || auth()->user()->role == 'Administrator'){
                        Session::put('firstname', $faculty->firstname);
                        Session::put('lastname', $faculty->lastname);
                        Session::put('avatar', $faculty->avatar);
                        Toastr::success('Login successfully :)','Success');
                        return redirect()->route('admin.dashboard')->with('alert-success', 'You are now logged in.');// this route is for the System Administrators
                    }else if(auth()->user()->role == 'Honors and Awards Committee' || auth()->user()->role == 'Guidance Facilitator'){
                        Session::put('firstname', $faculty->firstname);
                        Session::put('lastname', $faculty->lastname);
                        Session::put('avatar', $faculty->avatar);
                        Toastr::success('Login successfully :)','Success');
                        return redirect()->route('staff.dashboard')->with('alert-success', 'You are now logged in.');// this route is for the Honors and Awards Committee
                    }else if(auth()->user()->role == 'Faculty'){
                        Session::put('firstname', $faculty->firstname);
                        Session::put('lastname', $faculty->lastname);
                        Session::put('avatar', $faculty->avatar);
                        if($class_advisoryCTR != 0){
                            Session::put('role', 'Adviser');
                        }else{
                            Session::put('role', 'Subject Teacher');
                        }
                        Toastr::success('Login successfully :)','Success');
                        return redirect()->route('faculty.dashboard')->with('alert-success', 'You are now logged in.');// this route is for the Subject Teacher
                    }else if(auth()->user()->role == 'Junior High School Student' || auth()->user()->role == 'Senior High School Student'){
                        Session::put('firstname', $student->firstname);
                        Session::put('lastname', $student->lastname);
                        Session::put('avatar', $student->avatar);
                        Session::put('grade_level', $student->grade_level);
                        Toastr::success('Login successfully :)','Success');
                        return redirect()->route('student.dashboard')->with('alert-success', 'You are now logged in.');// this route is for the Non-Graduating Junior High School
                    // }else if(auth()->user()->role == 'Graduating Junior High School student and qualified for honors'){
                    //     return redirect()->route('student.dashboard')->with('alert-success', 'You are now logged in.');// this route is for the Graduating Junior High School student and qualified for honors
                    // }else if(auth()->user()->role == 'Non-graduating Senior High School student or non-qualified student for honors'){
                    //     return redirect()->route('student.dashboard')->with('alert-success', 'You are now logged in.');// this route is for the Non-Graduating Senior High School student or non-qualified for honors
                    // }else if(auth()->user()->role == 'Graduating Senior High School student and qualified for honors'){
                    //     return redirect()->route('student.dashboard')->with('alert-success', 'You are now logged in.');// this route is for the Graduating Senior High School and qualified for honors
                    }else{
                        return redirect()->route('/');
                    }
                }else{
                    Toastr::error('Login Data is incorrect','Invalid');
                    return redirect()->route('login');
                }
            } catch(\Exception $e) {
                DB::rollback();
                Toastr::error('fail, LOGIN :)','Error');
                return redirect()->back();
            }
    }
    public function logout( Request $request)
    {
        Auth::logout();
        // forget login session
        $request->session()->forget('firstname');
        $request->session()->forget('lastname');
        $request->session()->forget('avatar');
        $request->session()->forget('role');
        $request->session()->forget('grade_level');
        $request->session()->flush();

        Toastr::success('Logout successfully :)','Success');
        return redirect()->route('login');
    }
}
