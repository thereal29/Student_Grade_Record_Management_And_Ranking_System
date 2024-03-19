<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;use App\Models\StudentUser;
use App\Models\Subjects;
use App\Models\Classes;
use App\Models\ClassAdvisory;
use App\Models\FacultyStaff;
use App\Models\GradeSection;
use App\Models\SchoolYear;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class ClassAdvisoryController extends Controller
{
    public function index(){
        return view('admin.modules.other_list.class_advisory.index');
    }
    public function fetchSection(Request $request){
        $gradelevel = $request->gradelevel;
        if($gradelevel != null){
            $sections = GradeSection::select('*','student_gradelevel_section.id as sid', 'student_gradelevel_section.grade_level as glevel', 'faculty_staff_personal_details.firstname as ffname', 'faculty_staff_personal_details.lastname as flname', DB::raw('COUNT(student_personal_details.id) AS ctr'))->leftJoin('class_advisory', 'class_advisory.glevel_section_id', 'student_gradelevel_section.id')->leftJoin('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class_advisory.faculty_id')->leftJoin('student_personal_details', 'student_personal_details.glevel_section_id', '=', 'student_gradelevel_section.id')->groupBy('student_gradelevel_section.id')->where('student_gradelevel_section.grade_level', $gradelevel)->get();
        }else{
            $sections = GradeSection::select('*','student_gradelevel_section.id as sid', 'student_gradelevel_section.grade_level as glevel', 'faculty_staff_personal_details.firstname as ffname', 'faculty_staff_personal_details.lastname as flname', DB::raw('COUNT(student_personal_details.id) AS ctr'))->leftJoin('class_advisory', 'class_advisory.glevel_section_id', 'student_gradelevel_section.id')->leftJoin('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class_advisory.faculty_id')->leftJoin('student_personal_details', 'student_personal_details.glevel_section_id', '=', 'student_gradelevel_section.id')->groupBy('student_gradelevel_section.id')->get();
        } 
        
        $query = '';
        if($sections->count() >0){
            $query = '<table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
            <thead class="student-thread">
            <tr>
                <th>#</th>
                <th>Grade Level</th>
                <th>Section</th>
                <th>Adviser</th>
                <th>No. of Students</th>
                <th class="text-end">Action</th>
            </tr>
            </thead>
            <tbody>';
            foreach ($sections as $key => $section){
                $totalStud = $section->ctr ? $section->ctr : '0';
                $query .= '<tr>
                    <td>'. ++$key .'</td>
                    <td>'. $section->glevel .'</td>
                    <td>'. $section->section .'</td>';
                    if($section->ffname != null){
                        $query .= '<td>'. $section->ffname.' '.$section->flname.'</td>';
                    }else{
                        $query .= '<td>None</td>';
                    }
                    $query .= '<td>'. $totalStud;
                    if($totalStud != null){
                        if($totalStud > 1){
                            $query .= ' students</td>';
                        }else{
                            $query .= ' student</td>';
                        }
                    }else{
                        $query .= '0 student</td>';
                    }
             $query .= '<td class="text-end">
                            <div class="actions">
                                <a id="'.$section->sid.'" title="Assign Faculty" class="btn btn-sm bg-danger-light edit_section">
                                    <i class="feather-edit"></i>
                                </a>
                                <a id="'.$section->sid.'" value="'.$totalStud.'" title="Delete Faculty" class="btn btn-sm bg-danger-light delete_section">
                                    <i class="fe fe-trash-2"></i>
                                </a>
                            </div>
                        </td>
                </tr>';
            }
            $query .='</tbody></table>';
        }else{
            $query = '<h1 class="text-center text-secondary my-5">No record in the database!</h1>';
        }
        return response()->json([
            'status'=>'success',
            'query'=> $query,
            'gradelevel' => $gradelevel,
            'section' => $sections
        ]);
    }
    public function store(Request $request){
        $currentSY = SchoolYear::where('isCurrent', 1)->first();
        $section = new GradeSection;
        $section->grade_level = $request->grade_level;
        $section->section = $request->section;
        $section->save();
        $class_advisory = new ClassAdvisory;
        $class_advisory->faculty_id = $request->faculty;
        $class_advisory->glevel_section_id = $section->id;
        $class_advisory->sy_id = $currentSY->id;
        $class_advisory->save();
        return response()->json([
            'status'=>'success',
            'message'=>'Section Added Successfully.'
        ]);
    }
    public function delete(Request $request) {
        $id = $request->id;
        $subject = GradeSection::find($id);
        GradeSection::destroy($id);
    }
    public function edit(Request $request){
        $id = $request->id;
        $section = GradeSection::select('*','student_gradelevel_section.id as sid', 'student_gradelevel_section.grade_level as glevel', 'faculty_staff_personal_details.id as fid', 'faculty_staff_personal_details.firstname as ffname', 'faculty_staff_personal_details.lastname as flname')->leftJoin('class_advisory', 'class_advisory.glevel_section_id', 'student_gradelevel_section.id')->leftJoin('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class_advisory.faculty_id')->where('student_gradelevel_section.id', $id)->first();
        return response()->json($section);
    }
    public function update(Request $request){
        $request->validate([
            'grade_level'   => 'required|not_in:0',
            'section'   => 'required|string',
            'faculty' => 'required|not_in:0',
        ]);
        DB::beginTransaction();
            $id = $request->id;
            $currentSY = SchoolYear::where('isCurrent', 1)->first();
            $section = GradeSection::find($request->sec_id);
            $section->grade_level = $request->grade_level;
            $section->section = $request->section;
            $section->update();
            $class_advisoryCTR = ClassAdvisory::where('class_advisory.glevel_section_id', $request->sec_id)->count();
            if($class_advisoryCTR){
                $class_advisory = ClassAdvisory::where('class_advisory.glevel_section_id', $request->sec_id)->first();
                $class_advisory->faculty_id = $request->faculty;
                $class_advisory->glevel_section_id = $request->sec_id;
                $class_advisory->sy_id = $currentSY->id;
                $class_advisory->update();
            }else{
                $class_advisory = new ClassAdvisory;
                $class_advisory->faculty_id = $request->faculty;
                $class_advisory->glevel_section_id = $request->sec_id;
                $class_advisory->sy_id = $currentSY->id;
                $class_advisory->save();
            }
            DB::commit();
            return response()->json([
                'status'=>'success',
                'message'=>'Section Updated Successfully.'
            ]);
    }
}
