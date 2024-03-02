<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SchoolYear;
use RealRashid\SweetAlert\Facades\Alert;

class SchoolYearController extends Controller
{
    public function index(){
        $SYlist = DB::table('school_year')->get();
        $currentSY = DB::table('school_year')->select('*')->where('isCurrent', 1)->first();
        return view('admin.modules.school_year.index', compact('SYlist', 'currentSY'));
    }
    public function fetchSY(){
        $SYlist = DB::table('school_year')->get();
        $currentSY = DB::table('school_year')->select('*')->where('isCurrent', 1)->first();
        $query = '';
        if($SYlist->count() > 0){
            $query = '<table class="table border-0 star-student table-hover table-center mb-0 datatables table-striped">
            <thead class="student-thread">
                <tr>
                    <th>#</th>
                    <th>School Year</th>
                    <th>Quarter</th>
                    <th>Default?</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="row_data">';
            foreach($SYlist as $key=>$SY){
                $query .= '<tr>
                <td>'. ++$key .'</td>
                <td><div class="badge badge-info">'.$SY->from_year.'-'. $SY->to_year .'</div></td>
                <td><div class="badge badge-warning">'.$SY->quarter.'</div></td>';
                if($SY->isCurrent == 1){
                    $query .= '<td><div class="badge badge-success">Yes</div></td>';
                }else{
                    $query .= '<td><div class="badge badge-danger">No</div></td>';
                }
                $query .= '<td style="width: 15%" class="text-center">
                    <a id="' . $SY->id . '" value="'. $SY->isCurrent .'" href="" class="btn btn-sm bg-danger-light editIcon">
                        <i class="feather-edit"></i>
                    </a>
                    <a id="' . $SY->id . '" class="btn btn-sm bg-danger-light delete deleteIcon" data-bs-toggle="modal" data-bs-target="#delete">
                        <i class="fe fe-trash-2"></i>
                    </a>
                </td>';
            }
            $query .= '</tbody></table>';
        }else{
            $query = '<h5 class="text-center text-secondary my-4">No data found</h5>';
        }
        return response()->json([
            'status'=>'success',
            'query'=> $query,
            'currentSY' => $currentSY
        ]);
    }
    public function store(Request $request){
        $SYlist = DB::table('school_year')->get();
        if(SchoolYear::where('from_year',$request->input('fromY'))->where('quarter', $request->input('quarter'))->exists()){
            return response()->json([
                'status'=>'failed',
                'message'=>'Student Added Failed.'
            ]);
        }else{ 
            $newSY = new SchoolYear;
            $newSY->from_year = $request->input('fromY');
            $newSY->to_year = $request->input('toY');
            $newSY->quarter = $request->input('quarter');
            $newSY->isCurrent = 0;
            $newSY->save();
            return response()->json([
                'status'=>'success',
                'message'=>'Student Added Successfully.'
            ]);
        } 
    }
    public function edit(Request $request){
        $SY = SchoolYear::findOrFail($request->id);
        $currentSY = SchoolYear::where('isCurrent',1)->first();
        if($SY->isCurrent == $currentSY->isCurrent){
            return response()->json([
                'status'=>'warning'
            ]);
        }else{
            $SY->isCurrent = 1;
            $currentSY->isCurrent = 0;
            $SY->save();
            $currentSY->save();
            return response()->json([
            'status'=>'success'
            ]);
        }
    }
    public function delete(Request $request){
        $id = $request->id;
        $sy = SchoolYear::find($id);
        SchoolYear::destroy($id);
    }
}
