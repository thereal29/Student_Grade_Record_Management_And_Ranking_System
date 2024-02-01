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
                $faculty = FacultyStaff::select('*')->join('faculty_staff_user_mapping', 'faculty_staff_user_mapping.faculty_staff_id', '=', 'faculty_staff_personal_details.id')->join('users', 'users.id', '=', 'faculty_staff_user_mapping.user_id')->where('users.email', $input["email"])->first();
                if(auth()->attempt(['email'=>$input["email"], 'password'=>$input["password"]])){
                    if(auth()->user()->role == 'Administrator'){
                        Toastr::success('Login successfully :)','Success');
                        Session::put('firstname', $faculty->firstname);
                        Session::put('lastname', $faculty->lastname);
                        Session::put('avatar', $faculty->avatar);
                        return redirect()->route('admin.dashboard')->with('alert-success', 'You are now logged in.');// this route is for the System Administrator
                    }else if(auth()->user()->role == 'Honors and Awards Committee'){
                        return redirect()->route('honors_committee.dashboard')->with('alert-success', 'You are now logged in.');// this route is for the Honors and Awards Committee
                    }else if(auth()->user()->role == 'Guidance Facilitator'){
                        return redirect()->route('guidance_facilitator.dashboard')->with('alert-success', 'You are now logged in.');// this route is for the Guidance Facilitator
                    }else if(auth()->user()->role == 'Adviser'){
                        return redirect()->route('teacher.dashboard')->with('alert-success', 'You are now logged in.');// this route is for the Adviser
                    }else if(auth()->user()->role == 'Subject Teacher'){
                        return redirect()->route('teacher.dashboard')->with('alert-success', 'You are now logged in.');// this route is for the Subject Teacher
                    }else if(auth()->user()->role == 'Non-graduating Junior High School' || auth()->user()->role == 'Graduating Junior High School student and qualified for honors' ||
                    auth()->user()->role == 'Non-graduating Senior High School student or non-qualified student for honors' || auth()->user()->role == 'Graduating Senior High School student and qualified for honors'){
                        return redirect()->route('student.dashboard')->with('alert-success', 'You are now logged in.');// this route is for the Non-Graduating Junior High School
                    // }else if(auth()->user()->role == 'Graduating Junior High School student and qualified for honors'){
                    //     return redirect()->route('stud2.dashboard')->with('alert-success', 'You are now logged in.');// this route is for the Graduating Junior High School student and qualified for honors
                    // }else if(auth()->user()->role == 'Non-graduating Senior High School student or non-qualified student for honors'){
                    //     return redirect()->route('stud3.dashboard')->with('alert-success', 'You are now logged in.');// this route is for the Non-Graduating Senior High School student or non-qualified for honors
                    // }else if(auth()->user()->role == 'Graduating Senior High School student and qualified for honors'){
                    //     return redirect()->route('stud4.dashboard')->with('alert-success', 'You are now logged in.');// this route is for the Graduating Senior High School and qualified for honors
                    }else{
                        return redirect()->route('/');
                    }
                }else{
                    Toastr::error('Login Data is incorrect','Invalid');
                    return redirect('login');
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
        $request->session()->flush();

        Toastr::success('Logout successfully :)','Success');
        return redirect('login');
    }
}
