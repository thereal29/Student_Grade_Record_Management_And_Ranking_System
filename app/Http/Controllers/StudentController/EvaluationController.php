<?php

namespace App\Http\Controllers\StudentController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\EvaluationIndicator;
use App\Models\SchoolYear;
use App\Models\StudentUser;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    public function maincontent(){
        $user_id = auth()->user()->id;
        $details = StudentUser::join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->where('users.id', $user_id)->first();
        $students = StudentUser::select('*','student_personal_details.id as sid', 'student_personal_details.firstname as sfname', 'student_personal_details.lastname as slname')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->join('school_year', 'school_year.id', '=', 'users.sy_id')->where('student_gradelevel_section.grade_level', 'Grade 10')->get();
        return view('student.modules.character_evaluation.index', compact('details', 'user_id', 'students'));
    }
    public function fetchQuestions(Request $request){
        $question = EvaluationIndicator::select('*','character_evaluation_indicator.id AS indID', 'character_evaluation.id AS eid')->leftJoin('character_evaluation', 'character_evaluation_indicator.eval_id', '=', 'character_evaluation.id')->where('character_evaluation.status', 1)->orderBy('order')->get();
        $query = '';
        if($question->count() !=0){
            $query = '<table class="table border-0 table-striped datatables table-condensed">
            <thead class="student-thread">
                <tr>
                    <th style="width: 50% !important;">Indicator/Description</th>
                    <th class="text-center">5</th>
                    <th class="text-center">4</th>
                    <th class="text-center">3</th>
                    <th class="text-center">2</th>
                    <th class="text-center">1</th>
                </tr>
            </thead>
            <tbody>';
        foreach($question as $questionList){
            $query .= '<tr class="row1" data-id="'.$questionList->indID.'">
                <td style="width: 50% !important; white-space: normal !important;">'.$questionList->description.'</td>
                <td class="text-center"><input type="radio" id="'.$questionList->indID.'_1" name="ans_eval_'.$questionList->indID.'" value="1" required></td>
                <td class="text-center"><input type="radio" id="'.$questionList->indID.'_2" name="ans_eval_'.$questionList->indID.'" value="2" required></td>
                <td class="text-center"><input type="radio" id="'.$questionList->indID.'_3" name="ans_eval_'.$questionList->indID.'" value="3" required></td>
                <td class="text-center"><input type="radio" id="'.$questionList->indID.'_4" name="ans_eval_'.$questionList->indID.'" value="4" required></td>
                <td class="text-center"><input type="radio" id="'.$questionList->indID.'_5" name="ans_eval_'.$questionList->indID.'" value="5" required></td>
            </tr>';
        }
        $query .= '</tbody></table>';
    }else{
        $query = '<h5 class="text-center text-secondary my-4">No data found</h5>';
    }
        return response()->json([
            'status'=>'success',
            'query'=> $query
        ]);
    }
}
