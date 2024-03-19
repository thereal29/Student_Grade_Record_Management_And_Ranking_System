<?php

namespace App\Http\Controllers\StaffController;

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
        $currSY = SchoolYear::select('*')->where('isCurrent', 1)->first();
        if($SY == 'Show All'){
            \Session::put('fromSY', $SY);
            \Session::put('toSY', '');
            $selSY = \Session::get('fromSY');
            $selSY2 = \Session::get('toSY');
            $studentCTR_selSY = User::join('school_year', 'school_year.id', '=', 'users.sy_id')->whereIn('role', array('6','7'))->count();
        }else{
        $currSelSY = SchoolYear::select('*')->where('from_year', $SY)->first();
        if($currSelSY){
            \Session::put('fromSY', $currSelSY->from_year);
            \Session::put('toSY', $currSelSY->to_year);
            \Session::put('quarter', $currSelSY->to_year);
        }
        $selSY = \Session::get('fromSY');
        $selSY2 = \Session::get('toSY');
        //ctr for selected SY
        $studentCTR_selSY = User::join('school_year', 'school_year.id', '=', 'users.sy_id')->where('school_year.from_year', $selSY)->whereIn('role', array('6','7'))->count();
        }
        //ctr for current SY
        $studentCTR_currSY = User::join('school_year', 'school_year.id', '=', 'users.sy_id')->where('school_year.from_year', $currSY->from_year)->whereIn('role', array('6','7'))->count();
        // ctr for all SY
        $studentCTR = User::join('school_year', 'school_year.id', '=', 'users.sy_id')->whereIn('role', array('6','7'))->count();
        return view('staff.dashboard', compact('selSY','selSY2','currSY','studentCTR', 'studentCTR_selSY', 'studentCTR_currSY'));
    }
}
