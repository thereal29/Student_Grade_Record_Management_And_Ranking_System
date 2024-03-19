<?php

namespace App\Http\Controllers\AdminController;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoCurricularType;
use App\Models\CoCurricularSubType;
use App\Models\CoCurricularAwardScope;
use App\Models\CoCurricular;
use App\Models\CoCurricularDetails;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use App\Events\StudentActivityStatusUpdated;
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
    public function fetchActivity(Request $request){
        $gradelevel = $request->gradelevel;
        $selSY = \Session::get('fromSY');
        if($selSY == "Show All"){
            if($request->gradelevel != null && $request->gradelevel != 'showall'){
                $activities = CoCurricularDetails::select('*', 'co_curricular_activity_details.id as cid', 'co_curricular_activity.id as cc_id')->join('student_personal_details', 'student_personal_details.id', '=', 'co_curricular_activity_details.student_id')->join('co_curricular_activity', 'co_curricular_activity.id', '=', 'co_curricular_activity_details.cocurricular_id')->join('cocurricular_activity_type', 'cocurricular_activity_type.id', '=', 'co_curricular_activity.typeID')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.id', '=', 'co_curricular_activity.subtypeID')->leftJoin('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.id', '=', 'co_curricular_activity.award_scopeID')->where('co_curricular_activity_details.status', 'Submitted')->where('co_curricular_activity_details.grade_level', $gradelevel)->get();
                $point = CoCurricularDetails::select(DB::raw('sum(partialtotalPoints) AS sumTotal'))->groupBy('student_id')->where('co_curricular_activity_details.grade_level', $gradelevel)->first();
            }else{
                $activities = CoCurricularDetails::select('*', 'co_curricular_activity_details.id as cid', 'co_curricular_activity.id as cc_id')->join('student_personal_details', 'student_personal_details.id', '=', 'co_curricular_activity_details.student_id')->join('co_curricular_activity', 'co_curricular_activity.id', '=', 'co_curricular_activity_details.cocurricular_id')->join('cocurricular_activity_type', 'cocurricular_activity_type.id', '=', 'co_curricular_activity.typeID')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.id', '=', 'co_curricular_activity.subtypeID')->leftJoin('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.id', '=', 'co_curricular_activity.award_scopeID')->where('co_curricular_activity_details.status', 'Submitted')->get();
                $point = CoCurricularDetails::select(DB::raw('sum(partialtotalPoints) AS sumTotal'))->groupBy('student_id')->first();
            }
        }else{
            if($request->gradelevel != null && $request->gradelevel != 'showall'){
                $activities = CoCurricularDetails::select('*', 'co_curricular_activity_details.id as cid', 'co_curricular_activity.id as cc_id')->join('student_personal_details', 'student_personal_details.id', '=', 'co_curricular_activity_details.student_id')->join('co_curricular_activity', 'co_curricular_activity.id', '=', 'co_curricular_activity_details.cocurricular_id')->join('cocurricular_activity_type', 'cocurricular_activity_type.id', '=', 'co_curricular_activity.typeID')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.id', '=', 'co_curricular_activity.subtypeID')->leftJoin('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.id', '=', 'co_curricular_activity.award_scopeID')->join('school_year', 'school_year.id', '=', 'co_curricular_activity_details.sy_id')->where('school_year.from_year', $selSY)->where('co_curricular_activity_details.status', 'Submitted')->where('co_curricular_activity_details.grade_level', $gradelevel)->get();
                $point = CoCurricularDetails::select(DB::raw('sum(partialtotalPoints) AS sumTotal'))->groupBy('student_id')->where('co_curricular_activity_details.grade_level', $gradelevel)->first();
            }else{
                $activities = CoCurricularDetails::select('*', 'co_curricular_activity_details.id as cid', 'co_curricular_activity.id as cc_id')->join('student_personal_details', 'student_personal_details.id', '=', 'co_curricular_activity_details.student_id')->join('co_curricular_activity', 'co_curricular_activity.id', '=', 'co_curricular_activity_details.cocurricular_id')->join('cocurricular_activity_type', 'cocurricular_activity_type.id', '=', 'co_curricular_activity.typeID')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.id', '=', 'co_curricular_activity.subtypeID')->leftJoin('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.id', '=', 'co_curricular_activity.award_scopeID')->join('school_year', 'school_year.id', '=', 'co_curricular_activity_details.sy_id')->where('school_year.from_year', $selSY)->where('co_curricular_activity_details.status', 'Submitted')->get();
                $point = CoCurricularDetails::select(DB::raw('sum(partialtotalPoints) AS sumTotal'))->groupBy('student_id')->first();
            }
        }
        $percentageTemp = $point ? $point->sumTotal * .10 : 0;
        $percentage = number_format($percentageTemp, 2, '.', ',');
        $query = '<table class="table border-0 star-student table-hover table-center mb-0 datatables table-striped">
            <thead class="student-thread">
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Type of Activity</th>
                    <th>Category</th>
                    <th>Awards/Scope</th>
                    <th>Points</th>
                    <th>Status</th>
                    <th>Proof</th>
                    <th class="text-end">Action</th>

                </tr>
            </thead>
            <tbody id="activity_data">';
            foreach($activities as $key => $activity){
                $query .= '<tr>
                    <td>'. ++$key .'</td>
                    <td>'. $activity->firstname.' '. $activity->lastname .'</td>
                    <td>'. $activity->type_of_activity .'</td>
                    <td>'. $activity->subtype .'</td>
                    <td>'. $activity->award_scope .'</td>
                    <td>'. $activity->partialtotalPoints .'</td>
                    <td><div class="badge badge-warning" style="font-size:10px; text-transform: uppercase; font-style: italic;">'. $activity->status .'</div></td>
                    <td class="text-center">
                    <a href="'. route("view-validation-activity", ['id' => $activity->proof]) .'" target="_blank"><i class="feather-file" style="color:#05300e; text-decoration:none;" id="'.$activity->cid.'" title="'.$activity->proof.'"></i></a>
                    </td>
                    <td>
                        <a type="submit" id="'.$activity->cid.'" class="btn btn-sm bg-danger-light validate_activity d-flex">
                        <div class="badge badge-success" style="font-size:14px;">
                            <i class="fas fa-check"></i> Validate
                        </div>
                        </a>
                        <input id="cid" value="'.$activity->cid.'" class="form-control" name="revertID" hidden>
                        <a type="submit" id="'.$activity->cid.'" class="btn btn-sm bg-danger-light revert_activity d-flex">
                        <div class="badge badge-danger" style="font-size:14px;">
                            <i class="fa fa-undo"></i> Revert
                        </div>
                        </a>
                    </td>
                </tr>';
            }
            $query .= '</tbody></table>';
        return response()->json([
            'status'=>'success',
            'query'=> $query,
            'point' => $point,
            'percentage' => $percentage,
            'activity' => $activities
        ]);
    }
    public function show($id)
    {
        $co_curricular = CoCurricularDetails::where('proof', $id)->first();
        $file = Storage::disk('local')->path('uploads'. DIRECTORY_SEPARATOR .$co_curricular->proof);

        return response()->file($file);
    }
    public function validateActivity(Request $request){
        DB::beginTransaction();
        $activity_id = $request->id;
        $activities = CoCurricularDetails::where('id', $activity_id)->first();
        $activities->status = 'Validated';
        $activities->status_update_date = date('Y-m-d H:i:s');
        $activities->save();
        DB::commit();
        broadcast(new StudentActivityStatusUpdated($activities));
        return response()->json([
            'status'=>'success'
        ]);
    }
    public function revertActivity(Request $request){
        DB::beginTransaction();
        $activity_id = $request->id;
        $activities = CoCurricularDetails::where('id', $activity_id)->first();
        $activities->status = 'Reverted';
        $activities->status_update_date = date('Y-m-d H:i:s');
        $activities->save();
        DB::commit();
        return response()->json([
            'status'=>'success'
        ]);
    }
    
}