<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;

class PrintableDocumentController extends Controller
{
    public function generatePDF()
    {
        $students = Student::all();
        $header = view('pdf_header')->render();
        $footer = view('pdf_footer')->render();
        $pdf = PDF::loadView('students_pdf', compact('students', 'header', 'footer'));
        
        return $pdf->stream('students.pdf');
    }
}
