<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SchoolYear;
use App\Models\Classes;
use App\Models\FacultyStaff;
class DashboardController extends Controller
{
    public function index(){
        $SY = request()->post('schoolyear');
        $currSY = SchoolYear::select('*')->where('from_year', $SY)->first();
        if($currSY != null){
            \Session::put('fromSY', $currSY->from_year);
            \Session::put('toSY', $currSY->to_year);
        }
        $selSY = \Session::get('fromSY');
        $facultyCTR = User::join('school_year', 'school_year.id', '=', 'users.sy_id')->where('school_year.from_year', $selSY)->whereIn('role', array('4','5'))->count();
        $studentCTR = User::join('school_year', 'school_year.id', '=', 'users.sy_id')->where('school_year.from_year', $selSY)->whereIn('role', array('6','7','8','9'))->count();
        $class = Classes::join('school_year', 'school_year.id', '=', 'class.sy_id')->where('school_year.from_year', $selSY)->get();
        $userCTR = $facultyCTR +  $studentCTR;
        $classCTR = $class->count();
        return view('admin.dashboard', compact('userCTR', 'facultyCTR', 'studentCTR', 'classCTR'));
    }
}
