<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoCurricularType;
use App\Models\CoCurricularSubType;
use App\Models\CoCurricularAwardScope;
use App\Models\CoCurricular;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
class CoCurricularController extends Controller
{
    public function maincontent(){
        $type = CoCurricularType::all();
        $subtype = CoCurricularSubType::all();
        $awardscope = CoCurricularAwardScope::all();
        $activityList = DB::table('co_curricular_activity')->select('*', 'cocurricular_activity_type.id AS tid', 'co_curricular_activity.id AS ccaid', 'cocurricular_activity_subtype.point AS subtype_point', 'cocurricular_activity_award_scope.point AS award_scope_point')->join('cocurricular_activity_type', 'cocurricular_activity_type.id', '=', 'co_curricular_activity.typeID')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.id', '=', 'co_curricular_activity.subtypeID')->leftJoin('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.id', '=', 'co_curricular_activity.award_scopeID')->get();
        //$totalPoints = $activityList->subtype_point * $activityList->award_scope_point;
       return view('admin.modules.co_curricular_activity.index', compact('activityList','type', 'subtype', 'awardscope'));
    }
    
    public function addNew(){
        $type = CoCurricularType::all();
        $subtype = CoCurricularSubType::all();
        $awardscope = CoCurricularAwardScope::all();
        return view('admin.modules.co_curricular_activity.view_add', compact('type', 'subtype', 'awardscope'));
    }
    public function addActivity(Request $request){
        $type = new CoCurricularType;
        $subtype = new CoCurricularSubType;
        $awardscope = new CoCurricularAwardScope;
        $type->type_of_activity = $request->input('typeCoCurricular');
        $type->save();
        $subtype->subtype = $request->input('subTypeCoCurricular');
        $subtype->point = $request->input('subTypeCoCurricularPoint');
        $subtype->parentID = $type->id;
        $awardscope->award_scope = $request->input('awardscopeCoCurricular');
        $awardscope->point = $request->input('awardscopeCoCurricularPoint');
        $awardscope->parentID = $type->id;
        $subtype->save();
        $awardscope->save();
        Alert::success('Added Successfully', 'New Co Curricular Activity is Added');
        return redirect()->route('admin.co_curricular_activity.index');
    }
    public function edit(Request $request){
        $coCurricularID = $request->id;
        $coCurricular = DB::table('co_curricular_activity')->select('*','co_curricular_activity.id AS ccaid', 'cocurricular_activity_type.id AS tid','cocurricular_activity_subtype.id AS stid', 'cocurricular_activity_award_scope.id AS asid', 'cocurricular_activity_subtype.point AS subtype_point', 'cocurricular_activity_award_scope.point AS award_scope_point')->join('cocurricular_activity_type', 'cocurricular_activity_type.id', '=', 'co_curricular_activity.typeID')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.id', '=', 'co_curricular_activity.subtypeID')->leftJoin('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.id', '=', 'co_curricular_activity.award_scopeID')->where('co_curricular_activity.id', $coCurricularID)->first();
        return response()->json($coCurricular);
    }
    public function updateActivity(Request $request, $id){
        $coCurricular = CoCurricular::findOrFail($id);
        $coCurricular->typeID = $request->input('typeCoCurricular');
        $coCurricular->subtypeID = $request->input('subTypeCoCurricular');
        $coCurricular->award_scopeID = $request->input('awardscopeCoCurricular');
        $coCurricular->save();
        $subtype = CoCurricularSubType::where('id', $coCurricular->subtypeID)->first();
        $subtype->point = $request->input('subTypeCoCurricularPoint');
        $subtype->save();
        $awardscope = CoCurricularAwardScope::where('id', $coCurricular->award_scopeID)->first();
        $awardscope->point = $request->input('awardscopeCoCurricularPoint');
        $awardscope->save();
        Alert::success('Updated Successfully', 'Co Curricular Activity is Updated');
        return redirect()->route('admin.co_curricular_activity.index');
    }


    
}