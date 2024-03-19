<?php

namespace App\Http\Controllers\TeacherController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentUser;
use App\Models\Classes;
use PDF;

class PrintableDocumentController extends Controller
{
    public function generateClassPDF($id)
    {
        $classes = Classes::select('*', 'class.id as cid','subject.grade_level AS class_glevel')->join('subject', 'subject.id', '=', 'class.subject_id')->join('student_subject', 'student_subject.subject_id', '=', 'subject.id')->join('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->join('school_year', 'school_year.id', '=', 'class.sy_id')->where('class.id', $id)->get();
        $classes_sel = Classes::select('*', 'class.id as cid','subject.grade_level AS class_glevel')->join('subject', 'subject.id', '=', 'class.subject_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->join('school_year', 'school_year.id', '=', 'class.sy_id')->where('class.id', $id)->first();
        $header = view('layouts.pdf_header')->render();
        $footer = view('layouts.pdf_footer')->render();
        $pdf = PDF::loadView('printable.class', compact('classes', 'header', 'footer', 'classes_sel'));
        $fileName = strtolower(str_replace(' ', '_',$classes_sel->subject_description.' - '.$classes_sel->lastname.' '.$classes_sel->firstname.' (class data)')).'.pdf';
        return $pdf->stream($fileName);
    }
    public function generateAdviseesPDF($id)
    {
        $students = StudentUser::select('*', 'student_personal_details.firstname AS sfname', 'student_personal_details.lastname AS slname', 'student_personal_details.gender AS sgender')->join('student_subject', 'student_subject.student_id', '=', 'student_personal_details.id')->join('subject', 'subject.id', '=', 'student_subject.subject_id')->leftJoin('class', 'class.subject_id', '=', 'subject.id')->leftJoin('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->join('grades_per_subject', 'grades_per_subject.student_subject_id', '=', 'student_subject.id')->join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->where('student_personal_details.id', $id)->get();
        $student_sel = StudentUser::join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->join('student_subject', 'student_subject.student_id', '=', 'student_personal_details.id')->join('subject', 'subject.id', '=', 'student_subject.subject_id')->join('class', 'class.subject_id', '=', 'subject.id')->join('school_year', 'school_year.id', '=', 'class.sy_id')->where('student_personal_details.id', $id)->first();
        $header = view('layouts.pdf_header')->render();
        $footer = view('layouts.pdf_footer')->render();
        $pdf = PDF::loadView('printable.advisees_grades', compact('students', 'header', 'footer', 'student_sel'));
        $fileName = strtolower(str_replace(' ', '_',$student_sel->lastname.' '.$student_sel->firstname.' (certificate of grades)')).'.pdf';
        return $pdf->stream($fileName);
    }
}
