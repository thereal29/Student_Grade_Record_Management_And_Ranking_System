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
        $currSY = SchoolYear::select('*')->where('isCurrent', 1)->first();
        if($SY == 'Show All'){
            \Session::put('fromSY', $SY);
            \Session::put('toSY', '');
            $selSY = \Session::get('fromSY');
            $selSY2 = \Session::get('toSY');
            $facultyCTR_selSY = User::join('school_year', 'school_year.id', '=', 'users.sy_id')->where('role', '5')->count();
            $staffCTR_selSY = User::join('school_year', 'school_year.id', '=', 'users.sy_id')->whereIn('role', array('1','2','3','4'))->count();
            $studentCTR_selSY = User::join('school_year', 'school_year.id', '=', 'users.sy_id')->whereIn('role', array('6','7'))->count();
            $class_sel = Classes::join('school_year', 'school_year.id', '=', 'class.sy_id')->get();
            $userCTR_selSY = $facultyCTR_selSY + $staffCTR_selSY +  $studentCTR_selSY;
            $classCTR_selSY = $class_sel->count();
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
        $facultyCTR_selSY = User::join('school_year', 'school_year.id', '=', 'users.sy_id')->where('school_year.from_year', $selSY)->where('role', '5')->count();
        $staffCTR_selSY = User::join('school_year', 'school_year.id', '=', 'users.sy_id')->where('school_year.from_year', $selSY)->whereIn('role', array('1','2','3','4'))->count();
        $studentCTR_selSY = User::join('school_year', 'school_year.id', '=', 'users.sy_id')->where('school_year.from_year', $selSY)->whereIn('role', array('6','7'))->count();
        $class_sel = Classes::join('school_year', 'school_year.id', '=', 'class.sy_id')->where('school_year.from_year', $selSY)->get();
        $userCTR_selSY = $facultyCTR_selSY + $staffCTR_selSY +  $studentCTR_selSY;
        $classCTR_selSY = $class_sel->count();
        }
        //ctr for current SY
        $facultyCTR_currSY = User::join('school_year', 'school_year.id', '=', 'users.sy_id')->where('school_year.from_year', $currSY->from_year)->where('role', '5')->count();
        $staffCTR_currSY = User::join('school_year', 'school_year.id', '=', 'users.sy_id')->where('school_year.from_year', $currSY->from_year)->whereIn('role', array('1','2','3','4'))->count();
        $studentCTR_currSY = User::join('school_year', 'school_year.id', '=', 'users.sy_id')->where('school_year.from_year', $currSY->from_year)->whereIn('role', array('6','7'))->count();
        $class_curr = Classes::join('school_year', 'school_year.id', '=', 'class.sy_id')->where('school_year.from_year', $currSY->from_year)->get();
        $userCTR_currSY = $facultyCTR_currSY + $staffCTR_currSY +  $studentCTR_currSY;
        $classCTR_currSY = $class_curr->count();
        // ctr for all SY
        $facultyCTR = User::join('school_year', 'school_year.id', '=', 'users.sy_id')->where('role', '5')->count();
        $staffCTR = User::join('school_year', 'school_year.id', '=', 'users.sy_id')->whereIn('role', array('1','2','3','4'))->count();
        $studentCTR = User::join('school_year', 'school_year.id', '=', 'users.sy_id')->whereIn('role', array('6','7'))->count();
        $class = Classes::join('school_year', 'school_year.id', '=', 'class.sy_id')->get();
        $userCTR = $facultyCTR + $staffCTR +  $studentCTR;
        $classCTR = $class->count();
        return view('admin.dashboard', compact('selSY','selSY2','currSY','facultyCTR', 'staffCTR', 'studentCTR', 'classCTR', 'userCTR', 'facultyCTR_selSY', 'staffCTR_selSY', 'studentCTR_selSY', 'classCTR_selSY', 'userCTR_selSY', 'facultyCTR_currSY', 'staffCTR_currSY', 'studentCTR_currSY', 'classCTR_currSY', 'userCTR_currSY'));
    }
}
