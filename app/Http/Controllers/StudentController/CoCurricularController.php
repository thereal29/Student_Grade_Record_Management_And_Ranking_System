<?php

namespace App\Http\Controllers\StudentController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoCurricularType;
use App\Models\CoCurricularSubType;
use App\Models\CoCurricularAwardScope;
use App\Models\CoCurricular;
use App\Models\CoCurricularDetails;
use App\Models\StudentUser;
use App\Models\SchoolYear;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Storage;

class CoCurricularController extends Controller
{
    public function index(Request $request){
        $user_id = auth()->user()->id;
        $studentID = StudentUser::select('student_personal_details.id')->join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->where('users.id', $user_id)->first();
        // $activityList = CoCurricularDetails::join('co_curricular_activity', 'co_curricular_activity.id', '=', 'co_curricular_activity_details.cocurricular_id')->join('cocurricular_activity_type', 'cocurricular_activity_type.id', '=', 'co_curricular_activity.typeID')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.id', '=', 'co_curricular_activity.subtypeID')->join('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.id', '=', 'co_curricular_activity.award_scopeID')->where('co_curricular_activity_details.student_id', $studentID->id)->get();
        $type = CoCurricularType::all();
        $subtype = CoCurricularSubType::all();
        $awardscope = CoCurricularAwardScope::all();
        if($request->gradelevel != null){
            $activityList = CoCurricularDetails::join('co_curricular_activity', 'co_curricular_activity.id', '=', 'co_curricular_activity_details.cocurricular_id')->join('cocurricular_activity_type', 'cocurricular_activity_type.id', '=', 'co_curricular_activity.typeID')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.id', '=', 'co_curricular_activity.subtypeID')->leftJoin('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.id', '=', 'co_curricular_activity.award_scopeID')->where('co_curricular_activity_details.student_id', $studentID->id)->get();
        }
        else{
            $activityList = CoCurricularDetails::join('co_curricular_activity', 'co_curricular_activity.id', '=', 'co_curricular_activity_details.cocurricular_id')->join('cocurricular_activity_type', 'cocurricular_activity_type.id', '=', 'co_curricular_activity.typeID')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.id', '=', 'co_curricular_activity.subtypeID')->leftJoin('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.id', '=', 'co_curricular_activity.award_scopeID')->where('co_curricular_activity_details.student_id', $studentID->id)->get();
        }
        $point = CoCurricularDetails::select(DB::raw('sum(partialtotalPoints) AS sumTotal'))->groupBy('student_id')->first();
        $percentageTemp = $point ? $point->sumTotal * .10 : 0;
        $percentage = number_format($percentageTemp, 2, '.', ',');
        return view('student.modules.co_curricular_activity.index', compact('activityList', 'type', 'subtype', 'awardscope', 'point', 'percentage'));
    }
    public function fetchActivity(Request $request){
        $user_id = auth()->user()->id;
        $gradelevel = $request->gradelevel;
        $sum = 0;
        $studentID = StudentUser::select('student_personal_details.id')->join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->where('users.id', $user_id)->first();
        if($request->gradelevel != null && $request->gradelevel != 'showall'){
            $activities = CoCurricularDetails::select('*', 'co_curricular_activity_details.id as cid', 'co_curricular_activity.id as cc_id')->join('co_curricular_activity', 'co_curricular_activity.id', '=', 'co_curricular_activity_details.cocurricular_id')->join('cocurricular_activity_type', 'cocurricular_activity_type.id', '=', 'co_curricular_activity.typeID')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.id', '=', 'co_curricular_activity.subtypeID')->leftJoin('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.id', '=', 'co_curricular_activity.award_scopeID')->where('co_curricular_activity_details.student_id', $studentID->id)->where('co_curricular_activity_details.grade_level', $gradelevel)->get();
            $activitiesCTR = CoCurricularDetails::select('*', 'co_curricular_activity_details.id as cid', 'co_curricular_activity.id as cc_id')->join('co_curricular_activity', 'co_curricular_activity.id', '=', 'co_curricular_activity_details.cocurricular_id')->join('cocurricular_activity_type', 'cocurricular_activity_type.id', '=', 'co_curricular_activity.typeID')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.id', '=', 'co_curricular_activity.subtypeID')->leftJoin('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.id', '=', 'co_curricular_activity.award_scopeID')->where('co_curricular_activity_details.student_id', $studentID->id)->where('co_curricular_activity_details.status', 'Validated')->count();
            $points = CoCurricularDetails::select(DB::raw('sum(partialtotalPoints) AS sumTotal'))->groupBy('student_id')->where('co_curricular_activity_details.status', 'Validated')->where('co_curricular_activity_details.grade_level', $gradelevel)->first();
            foreach($points as $point){
                $sum += $point->sumTotal;
            }
        }else{
            $activities = CoCurricularDetails::select('*', 'co_curricular_activity_details.id as cid', 'co_curricular_activity.id as cc_id')->join('co_curricular_activity', 'co_curricular_activity.id', '=', 'co_curricular_activity_details.cocurricular_id')->join('cocurricular_activity_type', 'cocurricular_activity_type.id', '=', 'co_curricular_activity.typeID')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.id', '=', 'co_curricular_activity.subtypeID')->leftJoin('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.id', '=', 'co_curricular_activity.award_scopeID')->where('co_curricular_activity_details.student_id', $studentID->id)->get();
            $activitiesCTR = CoCurricularDetails::select('*', 'co_curricular_activity_details.id as cid', 'co_curricular_activity.id as cc_id')->join('co_curricular_activity', 'co_curricular_activity.id', '=', 'co_curricular_activity_details.cocurricular_id')->join('cocurricular_activity_type', 'cocurricular_activity_type.id', '=', 'co_curricular_activity.typeID')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.id', '=', 'co_curricular_activity.subtypeID')->leftJoin('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.id', '=', 'co_curricular_activity.award_scopeID')->where('co_curricular_activity_details.student_id', $studentID->id)->where('co_curricular_activity_details.status', 'Validated')->count();
            $points = CoCurricularDetails::select(DB::raw('sum(partialtotalPoints) AS sumTotal'))->groupBy('student_id')->where('co_curricular_activity_details.status', 'Validated')->get();
            foreach($points as $point){
                $sum += $point->sumTotal;
            }
        }
        $percentageTemp = ($sum/$activitiesCTR) * .10;
        $percentage = number_format($percentageTemp, 2, '.', ',');
        $query= '';
        if($activities->count() >0){
            $query .= '<table class="table border-0 star-student table-hover table-center mb-0 datatables table-striped">
            <thead class="student-thread">
                <tr>
                    <th class="no-sort">Type of Activity</th>
                    <th class="no-sort">Category</th>
                    <th class="no-sort">Awards/Scope</th>
                    <th class="no-sort">Points</th>
                    <th class="no-sort">Status</th>
                    <th class="no-sort">Proof</th>
                    <th class="no-sort">Action</th>

                </tr>
            </thead>
            <tbody id="activity_data">';
            foreach($activities as $activity){
                $query .= '<tr id="student-'. $activity->cid.'">
                    <td>'. $activity->type_of_activity .'</td>
                    <td>'. $activity->subtype .'</td>
                    <td>'. $activity->award_scope .'</td>
                    <td>'. $activity->partialtotalPoints .'</td>';
                    if($activity->status == "Submitted"){
                        $query .= '<td class="student-status"><div class="badge badge-warning" style="font-size:10px; text-transform: uppercase; font-style: italic;">'. $activity->status .'</div></td>';
                    }else if($activity->status == "Validated"){
                        $query .= '<td class="student-status"><div class="badge badge-success" style="font-size:10px; text-transform: uppercase; font-style: italic;">'. $activity->status .'</div></td>';
                    }else if($activity->status == "Reverted"){
                        $query .= '<td class="student-status"><div class="badge badge-danger" style="font-size:10px; text-transform: uppercase; font-style: italic;">'. $activity->status .'</div></td>';
                    }else{
                        $query .= '<td class="student-status"><div class="badge badge-info" style="font-size:10px; text-transform: uppercase; font-style: italic;">'. $activity->status .'</div></td>';
                    }
                    $query .= '<td class="text-center">
                    <a href="'. route("view-activity", ['id' => $activity->proof]) .'" target="_blank"><i class="feather-file" style="color:#05300e; text-decoration:none;" id="'.$activity->cid.'" title="'.$activity->proof.'"></i></a>
                    </td>
                    <td>';
                        if($activity->status == "Reverted" || $activity->status == "Submitted"){
                            $query .= '<a type="submit" id="'.$activity->cid.'" class="btn btn-sm bg-danger-light delete_activity d-flex">
                            <div class="badge badge-danger" style="font-size:14px;">
                                <i class="fe fe-trash-2"></i> Delete
                            </div>
                            </a>';
                        }else if($activity->status == "Initialized"){
                            $query .= '<a type="submit" id="'.$activity->cid.'" class="btn btn-sm bg-danger-light submit_activity d-flex">
                            <div class="badge badge-success" style="font-size:14px;">
                                <i class="far fa-paper-plane"></i> Submit
                            </div>
                            </a>
                            <a type="submit" id="'.$activity->cid.'" class="btn btn-sm bg-danger-light delete_activity d-flex">
                            <div class="badge badge-danger" style="font-size:14px;">
                                <i class="fe fe-trash-2"></i> Delete
                            </div>
                            </a>';
                        }else{

                        }
                        $query .= '</td>
                </tr>';
            }
            $query .= '</tbody></table>';
            
        }else{
            $query = '<h5 class="text-center text-secondary my-4">No data found</h5>';
        }
        return response()->json([
            'status'=>'success',
            'query'=> $query,
            'point' => $percentageTemp,
            'sum' => $sum,
            'ctr' => $activitiesCTR,
            'percentage' => $percentage,
            'activity' => $activities
        ]);
    }
    public function store(Request $request){
        $user_id = auth()->user()->id;
        $currentSY = SchoolYear::where('isCurrent', 1)->first();
        $typeID = $request->typeCoCurricularsel;
        $type = CoCurricularType::where('id', $typeID)->first();
        $subtypeID = $request->subTypeCoCurricularsel;
        $award_scopeID = $request->awardscopeCoCurricularsel;
        $proof = $request->file('file');
        $award_scope = CoCurricularAwardScope::where('parentID',$typeID)->get();
        if($typeID == null){
            $validator = Validator::make($request->all(), [
            
                'typeCoCurricularsel'=> 'required',
            ]);
        }else if(($typeID == 1 || $typeID ==2) && ($subtypeID == null || $award_scopeID == null) ){
            if($subtypeID == null && $award_scopeID != null){
                $validator = Validator::make($request->all(), [
                    'subTypeCoCurricularsel'=>'required',
                    'file' => 'required|mimes:doc,docx,pdf|max:2048',
                ]);
            }else if($subtypeID != null && $award_scopeID == null){
                $validator = Validator::make($request->all(), [
                    'awardscopeCoCurricularsel'=>'required',
                    'file' => 'required|mimes:doc,docx,pdf|max:2048',
                ]);
            }else{
                $validator = Validator::make($request->all(), [
                    'subTypeCoCurricularsel'=>'required',
                    'awardscopeCoCurricularsel'=>'required',
                    'file' => 'required|mimes:doc,docx,pdf|max:2048',
                ]);
            }
        }else if(($typeID >= 3 && $typeID <= 5) && $subtypeID == null){
            $validator = Validator::make($request->all(), [
                'subTypeCoCurricularsel'=>'required',
                'awardscopeCoCurricularsel'=>'nullable',
                'file' => 'required|mimes:doc,docx,pdf|max:2048',
                
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'subTypeCoCurricularsel'=>'nullable',
                'awardscopeCoCurricularsel'=>'nullable',
                'file' => 'required|mimes:doc,docx,pdf|max:2048',
                
            ]);
        }
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }else{
            if($award_scope->count() == 0){
                $query = CoCurricular::select('*', 'co_curricular_activity.id as cid','cocurricular_activity_subtype.point AS subtypePoint', 'cocurricular_activity_award_scope.point AS award_scopePoint')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.id', '=', 'co_curricular_activity.subtypeID')
                ->leftJoin('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.id', '=', 'co_curricular_activity.award_scopeID')
                ->where('co_curricular_activity.typeID','=', $typeID)
                ->where('co_curricular_activity.subtypeID','=', $subtypeID)
                ->first();
            }else{
                $query = CoCurricular::select('*', 'co_curricular_activity.id as cid','cocurricular_activity_subtype.point AS subtypePoint', 'cocurricular_activity_award_scope.point AS award_scopePoint')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.id', '=', 'co_curricular_activity.subtypeID')
                ->leftJoin('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.id', '=', 'co_curricular_activity.award_scopeID')
                ->where('co_curricular_activity.typeID','=', $typeID)
                ->where('co_curricular_activity.subtypeID','=', $subtypeID)
                ->Where('co_curricular_activity.award_scopeID','=', $award_scopeID)
                ->first();
            }
            $studentID = StudentUser::select('*','student_personal_details.id AS sid')->join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->where('users.id', $user_id)->first();
            $fileName = $studentID->lastname.'_'.$studentID->grade_level.'_'.$type->type_of_activity.'_'.$proof->getClientOriginalName();
            $coCurricular = new CoCurricularDetails;
            $coCurricular->student_id = $studentID->sid;
            $coCurricular->cocurricular_id = $query->cid;
            $coCurricular->status = 'Initialized';
            $coCurricular->status_update_date = date('Y-m-d H:i:s');
            if($award_scope->count() == 0){
                $point = $query->subtypePoint;
            }else{
                $point = $query->subtypePoint * $query->award_scopePoint;
            }
            $coCurricular->partialtotalPoints = $point;
            $path = $proof->storeAs('uploads', $fileName);
            $relativePath = substr($path, strpos($path, '/') + 1);
            $coCurricular->proof = $relativePath;
            $coCurricular->grade_level = $studentID->grade_level;
            $coCurricular->sy_id = $currentSY->id;
            $coCurricular->save();
            Alert::success('Added Successfully', 'Co Curricular is Added');
            return response()->json([
                'status'=>'success',
                'message'=>'Student Added Successfully.',
                'a' => $typeID,
                'b' => $subtypeID,
                'c' => $award_scopeID,
                'cid' => $query->cid
            ]);
        }
    }
    public function submitActivity(Request $request){
        DB::beginTransaction();
        $id = $request->id;
        $activities = CoCurricularDetails::where('id', $id)->first();
        $activities->status = 'Submitted';
        $activities->status_update_date = date('Y-m-d H:i:s');
        $activities->save();
        DB::commit();
        return response()->json([
            'status'=>'success',
            'act' => $activities
        ]);
    }
    public function delete(Request $request){
        $id = $request->id;
        $activity = CoCurricularDetails::find($id);
        $filename = $activity->proof;
        Storage::disk('local')->delete('uploads/' . $filename);
        CoCurricularDetails::destroy($id);
    }
    public function add(Request $request){
        $user_id = auth()->user()->id;
        $temp = CoCurricular::where('typeID', $request->input('typeCoCurricularsel'))->where('subtypeID', $request->input('subTypeCoCurricularsel'))->where('award_scopeID', $request->input('awardscopeCoCurricularsel'))->first();
        $studentID = StudentUser::select('*','student_personal_details.id AS sid')->join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->where('users.id', $user_id)->first();
        $coCurricular = new CoCurricularDetails;
        $coCurricular->student_id = $studentID->sid;
        $coCurricular->cocurricular_id = $temp ? $temp->id : '';
        $coCurricular->status = 'Initialized';
        $coCurricular->status_update_date = date('Y-m-d H:i:s');
        $temp_point = CoCurricular::select('cocurricular_activity_subtype.point AS subtypePoint', 'cocurricular_activity_award_scope.point AS award_scopePoint')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.id', '=', 'co_curricular_activity.subtypeID')->leftJoin('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.id', '=', 'co_curricular_activity.award_scopeID')->where('cocurricular_activity_subtype.id', $temp->subtypeID)->where('cocurricular_activity_award_scope.id', $temp->award_scopeID)->first();
        $point = $temp_point->subtypePoint * $temp_point->award_scopePoint;
        $coCurricular->partialtotalPoints = $point;
        $coCurricular->grade_level = $studentID->grade_level;
        $coCurricular->save();
        Alert::success('Added Successfully', 'Co Curricular is Added');
        return redirect()->back();
    }
    public function edit(Request $request){
        $coCurricularID = $request->id;
        $coCurricular = DB::table('co_curricular_activity')->select('*','co_curricular_activity.id AS ccaid', 'cocurricular_activity_type.id AS tid','cocurricular_activity_subtype.id AS stid', 'cocurricular_activity_award_scope.id AS asid', 'cocurricular_activity_subtype.point AS subtype_point', 'cocurricular_activity_award_scope.point AS award_scope_point')->join('cocurricular_activity_type', 'cocurricular_activity_type.id', '=', 'co_curricular_activity.typeID')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.id', '=', 'co_curricular_activity.subtypeID')->leftJoin('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.id', '=', 'co_curricular_activity.award_scopeID')->where('co_curricular_activity.id', $coCurricularID)->first();
        
        return response()->json($coCurricular);
    }
    public function show($id)
    {
        $co_curricular = CoCurricularDetails::where('proof', $id)->first();
        $file = Storage::disk('local')->path('uploads'. DIRECTORY_SEPARATOR .$co_curricular->proof);

        return response()->file($file);
    }

}
