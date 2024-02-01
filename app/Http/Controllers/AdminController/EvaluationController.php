<?php

namespace App\Http\Controllers\AdminController;

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
        $evaluationTemp = DB::table('character_evaluation')->select('*')->leftJoin('character_evaluation_indicator', 'character_evaluation.id', '=', 'character_evaluation_indicator.eval_id')->leftJoin('school_year', 'school_year.id', '=', 'character_evaluation.sy_id')->first();
        $currentSY = DB::table('school_year')->select('*')->where('isCurrent', 1)->first();
        if($evaluationTemp != null){
            $existSY = DB::table('character_evaluation')->select('*')->where('sy_id', 'LIKE', $evaluationTemp->sy_id)->get();
            
        }else{
            $existSY = null;
        }
        return view('admin.modules.character_evaluation.index', compact('evaluationList', 'currentSY', 'existSY'));
    }
    public function addEval(Request $request){
        $evaluation = new Evaluation;
        $evaluation->sy_id = $request->input('currentSYid');
        $evaluation->status = 1;
        $evaluation->save();
        return redirect()->route('admin.character_evaluation')->with('success', 'Curriculum Successfully Created');
    }
    public function updateEval(Request $request){
        $evaluation = DB::table('character_evaluation')->select('*')->leftJoin('character_evaluation_indicator', 'character_evaluation.id', '=', 'character_evaluation_indicator.eval_id')->leftJoin('school_year', 'school_year.id', '=', 'character_evaluation.sy_id')->where('character_evaluation.id', $request->id)->first();
        return view('admin.character_evaluation_update', compact('evaluation'));
    }
    public function manageQ(Request $request){
        $currentSY = DB::table('school_year')->select('*')->where('isCurrent', 1)->first();
        $SY = DB::table('character_evaluation')->select('*')->leftJoin('character_evaluation_indicator', 'character_evaluation.id', '=', 'character_evaluation_indicator.eval_id')->leftJoin('school_year', 'school_year.id', '=', 'character_evaluation.sy_id')->where('character_evaluation.id', $request->id)->first();
        $question = DB::table('character_evaluation_indicator')->select('*','character_evaluation_indicator.id AS indID', 'character_evaluation.id AS eid')->leftJoin('character_evaluation', 'character_evaluation_indicator.eval_id', '=', 'character_evaluation.id')->where('character_evaluation_indicator.eval_id', $request->id)->get();     
        return view('admin.character_evaluation_manage_questions', compact('question','SY', 'currentSY'));
    }
    public function addQuestion(Request $request){
        $question = new EvaluationIndicator;
        $question->eval_id = $request->input('evalID');
        $question->description = $request->get('evalIndicator');
        $question->save();
        Alert::success('Added Successfully', 'New Evaluation Indicator is added');
        return redirect()->back();
    }
    public function delQuestion(Request $request){
        $question = EvaluationIndicator::find($request->input('qid'));
        $question->delete();
        // $question = DB::table('character_evaluation_indicator')->where('id', $request->input('#pass_id'))->delete();
        
        return redirect()->back();
    }
}
