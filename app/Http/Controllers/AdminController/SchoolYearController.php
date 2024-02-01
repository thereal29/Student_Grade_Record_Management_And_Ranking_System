<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SchoolYear;
use RealRashid\SweetAlert\Facades\Alert;

class SchoolYearController extends Controller
{
    public function maincontent(){
        $SYlist = DB::table('school_year')->get();
        $currentSY = DB::table('school_year')->select('*')->where('isCurrent', 1)->first();
        return view('admin.modules.settings.school_year.index', compact('SYlist', 'currentSY'));
    }

    public function addSY(Request $request){
        $newSY = new SchoolYear;
        $newSY->from_year = $request->input('fromY');
        $newSY->to_year = $request->input('toY');
        $newSY->quarter = $request->input('quarter');
        $newSY->isCurrent = 0;
        $newSY->save();
        Alert::success('Added Successfully', 'New School Year is Added');
        return redirect()->back();
    }
    public function editSY(Request $request, $id){
        $SY = SchoolYear::findOrFail($id);
        $SY->isCurrent = $request->input('status');
        $SY->save();
        Alert::success('Updated Successfully', 'School Year is Updated');
        return redirect()->back();
    }
}
