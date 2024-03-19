<?php

namespace App\Http\Controllers\TeacherController;
use App\Exports\ClassExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportClassExcel($id)
    {
        $classes_sel = Classes::select('*', 'class.id as cid','subject.grade_level AS class_glevel')->join('subject', 'subject.id', '=', 'class.subject_id')->join('school_year', 'school_year.id', '=', 'class.sy_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->where('class.id', $id)->first();
        $fileName = strtolower(str_replace(' ', '_',$classes_sel->subject_description.' - '.$classes_sel->lastname.' '.$classes_sel->firstname.' (class data)')).'.xlsx';
        return Excel::download(new ClassExport($id), $fileName);
    }
}
