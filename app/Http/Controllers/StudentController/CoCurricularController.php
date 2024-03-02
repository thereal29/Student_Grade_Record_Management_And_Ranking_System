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
        $studentID = StudentUser::select('student_personal_details.id')->join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->where('users.id', $user_id)->first();
        if($request->gradelevel != null && $request->gradelevel != 'showall'){
            $activities = CoCurricularDetails::select('*', 'co_curricular_activity_details.id as cid')->join('co_curricular_activity', 'co_curricular_activity.id', '=', 'co_curricular_activity_details.cocurricular_id')->join('cocurricular_activity_type', 'cocurricular_activity_type.id', '=', 'co_curricular_activity.typeID')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.id', '=', 'co_curricular_activity.subtypeID')->leftJoin('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.id', '=', 'co_curricular_activity.award_scopeID')->where('co_curricular_activity_details.student_id', $studentID->id)->where('co_curricular_activity_details.grade_level', $gradelevel)->get();
            $point = CoCurricularDetails::select(DB::raw('sum(partialtotalPoints) AS sumTotal'))->groupBy('student_id')->where('co_curricular_activity_details.grade_level', $gradelevel)->first();
        }else{
            $activities = CoCurricularDetails::select('*', 'co_curricular_activity_details.id as cid', 'co_curricular_activity.id as cc_id')->join('co_curricular_activity', 'co_curricular_activity.id', '=', 'co_curricular_activity_details.cocurricular_id')->join('cocurricular_activity_type', 'cocurricular_activity_type.id', '=', 'co_curricular_activity.typeID')->join('cocurricular_activity_subtype', 'cocurricular_activity_subtype.id', '=', 'co_curricular_activity.subtypeID')->leftJoin('cocurricular_activity_award_scope', 'cocurricular_activity_award_scope.id', '=', 'co_curricular_activity.award_scopeID')->where('co_curricular_activity_details.student_id', $studentID->id)->get();
            $point = CoCurricularDetails::select(DB::raw('sum(partialtotalPoints) AS sumTotal'))->groupBy('student_id')->first();
        }
        $percentageTemp = $point ? $point->sumTotal * .10 : 0;
        $percentage = number_format($percentageTemp, 2, '.', ',');
        $query= '';
        if($activities->count() >0){
            $query .= '<table class="table border-0 star-student table-hover table-center mb-0 datatables table-striped">
            <thead class="student-thread">
                <tr>
                    <th>Type of Activity</th>
                    <th>Category</th>
                    <th>Awards/Scope</th>
                    <th>Points</th>
                    <th>Status</th>
                    <th>Proof</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody id="activity_data">';
            foreach($activities as $activity){
                $query .= '<tr>
                    <td>'. $activity->type_of_activity .'</td>
                    <td>'. $activity->subtype .'</td>
                    <td>'. $activity->award_scope .'</td>
                    <td>'. $activity->partialtotalPoints .'</td>
                    <td>'. $activity->status .'</td>
                    <td class="text-center">
                    <a href=""><i class="feather-file" style="color:#05300e; text-decoration:none;" title="Add File"></i></a>
                    </td>
                    <td class="text-end">
                        <input name="_method" type="hidden" id="actID" value="' . $activity->cid . '">
                            <div class="actions">
                                <a id="' . $activity->cc_id . '" href="" class="btn btn-sm bg-danger-light">
                                    <i class="feather-edit"></i>
                                </a>
                                <a id="' . $activity->cid . '" class="btn btn-sm bg-danger-light delete deleteIcon" data-bs-toggle="modal" data-bs-target="#delete">
                                    <i class="fe fe-trash-2"></i>
                                </a>
                            </div>
                        </td>
                </tr>';
            }
            $query .= '</tbody></table>';
            
        }else{
            $query = '<h5 class="text-center text-secondary my-4">No data found</h5>';
        }
        return response()->json([
            'status'=>'success',
            'query'=> $query,
            'point' => $point,
            'percentage' => $percentage,
            'activity' => $activities
        ]);
    }
    public function store(Request $request){
        $user_id = auth()->user()->id;
        $typeID = $request->typeCoCurricularsel;
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
            $fileName = $studentID->lastname.'_'.$studentID->grade_level.'.'.$proof->getClientOriginalExtension();
            $proof->storeAs('files', $fileName);
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
            $coCurricular->proof = $fileName;
            $coCurricular->grade_level = $studentID->grade_level;
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
    public function delete(Request $request) {
        $id = $request->id;
        $activity = CoCurricularDetails::find($id);
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

}
