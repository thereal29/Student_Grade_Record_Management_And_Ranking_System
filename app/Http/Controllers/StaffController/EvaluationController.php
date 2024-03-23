<?php

namespace App\Http\Controllers\StaffController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\EvaluationIndicator;
use App\Models\SchoolYear;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class EvaluationController extends Controller
{
    public function maincontent(){
        $evaluationList = DB::table('character_evaluation')->select('*','character_evaluation.id AS eid')->leftJoin('character_evaluation_indicator', 'character_evaluation.id', '=', 'character_evaluation_indicator.eval_id')->leftJoin('school_year', 'school_year.id', '=', 'character_evaluation.sy_id')->groupBy(['eid'])->get();
        $evaluationTemp = DB::table('character_evaluation')->select('*','character_evaluation.id AS eid')->leftJoin('character_evaluation_indicator', 'character_evaluation.id', '=', 'character_evaluation_indicator.eval_id')->leftJoin('school_year', 'school_year.id', '=', 'character_evaluation.sy_id')->first();
        $currentSY = DB::table('school_year')->select('*')->where('isCurrent', 1)->first();
        if($evaluationTemp != null){
            $existSY = DB::table('character_evaluation')->select('*', 'character_evaluation.id AS eid')->where('sy_id', 'LIKE', $evaluationTemp->sy_id)->get();
            
        }else{
            $existSY = null;
        }
        return view('staff.modules.reports.evaluation.index', compact('evaluationList', 'currentSY', 'existSY'));
    }
    public function checkEval(){
        $id = $request->id;
        $evaluation = Evaluation::find($id);
        $ctr=$evaluation->count();
        return response()->json([
            'status'=>'success',
            'ctr' => $ctr
        ]);
    }
    public function fetchEvaluation(Request $request){
        $adviser = $request->adviser;
        $selSY = \Session::get('fromSY');
        if($selSY == 'Show All'){
            $evaluationList = DB::table('character_evaluation')->select('*','character_evaluation.id AS eid')->leftJoin('character_evaluation_indicator', 'character_evaluation.id', '=', 'character_evaluation_indicator.eval_id')->leftJoin('school_year', 'school_year.id', '=', 'character_evaluation.sy_id')->groupBy(['eid'])->get();
        }else{
            $evaluationList = DB::table('character_evaluation')->select('*','character_evaluation.id AS eid')->leftJoin('character_evaluation_indicator', 'character_evaluation.id', '=', 'character_evaluation_indicator.eval_id')->leftJoin('school_year', 'school_year.id', '=', 'character_evaluation.sy_id')->groupBy(['eid'])->where('school_year.from_year', $selSY)->get();
        }
        $evaluationTemp = DB::table('character_evaluation')->select('*','character_evaluation.id AS eid')->leftJoin('character_evaluation_indicator', 'character_evaluation.id', '=', 'character_evaluation_indicator.eval_id')->leftJoin('school_year', 'school_year.id', '=', 'character_evaluation.sy_id')->first();
        if($evaluationTemp != null){
            $temp = DB::table('character_evaluation')->select('*', 'character_evaluation.id AS eid')->where('sy_id', 'LIKE', $evaluationTemp->sy_id)->first();
            $existSY = $temp->sy_id;
            
        }else{
            $existSY = null;
        }
        $query = '<table class="table border-0 star-student table-hover table-center mb-0 datatables table-striped">
            <thead class="student-thread">
                <tr>
                    <th>#</th>
                    <th>School Year</th>
                    <th>Default?</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>';
            foreach($evaluationList as $key=>$evaluation){
                $query .= '<tr>
                <td>'.++$key.'</td>
                <td><div class="badge badge-warning"style="font-size:14px;">'.$evaluation->from_year.' - '.$evaluation->to_year.'</div></td>';
                if($evaluation->status == 1){
                $query .= '<td><center><div class="badge badge-success" style="font-size:14px;">Yes</div></center></td>';
                }else{
                $query .= '<td><center><div class="badge badge-danger" style="font-size:14px;">No</div></center></td>';
                }
                $query .= '<td class="text-end">
                        <a href="character_evaluation/results?id='.$evaluation->eid.'" id="'.$evaluation->eid.'" class="btn btn-sm bg-danger-light results_evaluation d-flex">
                        <div class="badge badge-success" style="font-size:14px;">
                            <i class="fas fa-eye"></i> View Results
                        </div>
                        </a>
                        <a href="character_evaluation/manage?id='.$evaluation->eid.'" id="'.$evaluation->eid.'" class="btn btn-sm bg-danger-light manageQ d-flex">
                        <div class="badge badge-warning" style="font-size:14px;">
                            <i class="feather-edit"></i> Manage Questionnaires
                        </div>
                        </a>
                        <a id="'.$evaluation->eid.'" class="btn btn-sm bg-danger-light delete_evaluation d-flex">
                            <div class="badge badge-danger" style="font-size:14px;">
                                <i class="fas fa-trash"></i> Delete Evaluation
                            </div>
                        </a>
                </td>
            </tr>';
            }
            $query .= '</tbody></table>';
        
            return response()->json([
            'status'=>'success',
            'query'=> $query,
            'existSY' => $existSY
        ]);

    }
    public function addEval(Request $request){
        $evaluation = new Evaluation;
        $evaluation->sy_id = $request->input('currentSYid');
        $evaluation->status = 1;
        $evaluation->save();
        
        $descriptions = [
            'Shows adherence to ethical principles by upholding truth.',
            'Demonstrates intellectual honesty.',
            'Aspires to be fair and kind to all.',
            "Recognizes and respects one's feelings and those of others.",
            'Views mistakes as learning opportunities.',
            'Upholds and respects the dignity and equality of all including those with special needs.',
            'Recognizes and respects people from different economic, social and cultural backgrounds.',
            'Recognizes and accepts the contribution of others toward a goal.',
            'Communicates respectfully and considers diverse views.',
            'Shows a caring attitude toward the environment.',
            'Takes care of school materials, facilities and equipment.',
            'Takes pride in diverse Filipino cultural expressions, practices and traditions.',
            'Abides by the rules of the school, community and the country.',
            'Manages time and personal resources efficiently and effectively.',
            'Perseveres to achieve goals despite difficult circumstances.'
        ];
    
        foreach ($descriptions as $index => $description) {
            $newQ = new EvaluationIndicator;
            $newQ->eval_id = $evaluation->id;
            $newQ->description = $description;
            $newQ->order = $index + 1;
            $newQ->save();
        }
        return response()->json([
            'status'=>'success'
        ]);
    }
    public function updateEval(Request $request){
        $evaluation = DB::table('character_evaluation')->select('*')->leftJoin('character_evaluation_indicator', 'character_evaluation.id', '=', 'character_evaluation_indicator.eval_id')->leftJoin('school_year', 'school_year.id', '=', 'character_evaluation.sy_id')->where('character_evaluation.id', $request->id)->first();
        return view('staff.character_evaluation_update', compact('evaluation'));
    }
    public function deleteEval(Request $request){
        $id = $request->id;
        $questions = EvaluationIndicator::where('eval_id', $id)->get();
        foreach($questions as $question){
            $question->delete();
        }
        Evaluation::destroy($id);
    }
    public function manageQ(Request $request){
        $currentSY = DB::table('school_year')->select('*')->where('isCurrent', 1)->first();
        $SY = DB::table('character_evaluation')->select('*')->leftJoin('character_evaluation_indicator', 'character_evaluation.id', '=', 'character_evaluation_indicator.eval_id')->leftJoin('school_year', 'school_year.id', '=', 'character_evaluation.sy_id')->where('character_evaluation.id', $request->id)->first();
        $question = DB::table('character_evaluation_indicator')->select('*','character_evaluation_indicator.id AS indID', 'character_evaluation.id AS eid')->leftJoin('character_evaluation', 'character_evaluation_indicator.eval_id', '=', 'character_evaluation.id')->where('character_evaluation_indicator.eval_id', $request->id)->get();     
        return view('staff.modules.reports.evaluation.manage_questions', compact('question','SY', 'currentSY'));
    }
    public function addQuestion(Request $request){
        if($request->input('formID') == null){
            $question = new EvaluationIndicator;
            $maxOrder = EvaluationIndicator::max('order');
            $question->eval_id = $request->evalID;
            $question->order = $maxOrder + 1;
            $question->description = $request->evalIndicator;
            $question->save();
        }else{
            $id = $request->indID;
            $questions = EvaluationIndicator::find($id);
            $questions->eval_id = $request->evalID;
            $questions->description = $request->evalIndicator;
            $questions->update();
        }
        
        return response()->json([
            'status'=>'success',
            'id' => $request->input('evalID')
        ]);
    }
    public function fetchQuestions(Request $request){
        $id = $request->get('id');
        $question = DB::table('character_evaluation_indicator')->select('*','character_evaluation_indicator.id AS indID', 'character_evaluation.id AS eid')->leftJoin('character_evaluation', 'character_evaluation_indicator.eval_id', '=', 'character_evaluation.id')->where('character_evaluation_indicator.eval_id', $id)->orderBy('order')->get();
        $query = '';
        if($question->count() !=0){
            $query = '<table class="table border-0 table-striped datatables table-condensed">
            <thead class="student-thread">
                <tr>
                    <th colspan="2" style="width: 50% !important;">Indicator/Description</th>
                    <th class="text-center">5</th>
                    <th class="text-center">4</th>
                    <th class="text-center">3</th>
                    <th class="text-center">2</th>
                    <th class="text-center">1</th>
                </tr>
            </thead>
            <tbody class="sortable">';
        foreach($question as $questionList){
            $query .= '<tr class="row1" data-id="'.$questionList->indID.'">
                <td class="p-1 text-center" width="5px">
                    <span class="btn-group dropright">
                        <span type="button" class="btn" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                        </span>
                        <div class="dropdown-menu">
                            <a class="dropdown-item edit_question" href="javascript:void(0)" id="'.$questionList->indID.'" data-id="'.$questionList->description.'" ><i class="feather-edit"></i>  Edit Indicator</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item delete_question" href="javascript:void(0)" id="'.$questionList->indID.'"> <i class="fas fa-trash"></i>  Delete Indicator </a>
                        </div>
                    </span>
                </td>
                <td style="width: 50% !important; white-space: normal !important;">'.$questionList->description.'</td>
                <td class="text-center"><input type="radio" id="'.$questionList->indID.'_1" name="ans_eval_'.$questionList->indID.'" value="1"></td>
                <td class="text-center"><input type="radio" id="'.$questionList->indID.'_2" name="ans_eval_'.$questionList->indID.'" value="2"></td>
                <td class="text-center"><input type="radio" id="'.$questionList->indID.'_3" name="ans_eval_'.$questionList->indID.'" value="3"></td>
                <td class="text-center"><input type="radio" id="'.$questionList->indID.'_4" name="ans_eval_'.$questionList->indID.'" value="4"></td>
                <td class="text-center"><input type="radio" id="'.$questionList->indID.'_5" name="ans_eval_'.$questionList->indID.'" value="5"></td>
            </tr>';
        }
        $query .= '</tbody></table>';
    }else{
        $query = '<h5 class="text-center text-secondary my-4">No data found</h5>';
    }
        return response()->json([
            'status'=>'success',
            'query'=> $query,
            'id' => $request->get('id')
        ]);
    }
    public function edit(Request $request){
        $id = $request->id;
        $question = EvaluationIndicator::find($id);
        return response()->json($question);
    }
    public function delete(Request $request){
        $id = $request->id;
        EvaluationIndicator::destroy($id);
    }
    public function sort(Request $request)
 {
     $questions = EvaluationIndicator::all();

     foreach ($questions as $question) {
         foreach ($request->order as $order) {
             if ($order['id'] == $question->id) {
                $question->order = $order['position'];
                 $question->update();
             }
         }
     }
     return response()->json([
        'status'=>'success'
    ]);
 }
}
