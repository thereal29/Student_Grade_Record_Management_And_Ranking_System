<?php

namespace App\Exports;
use App\Models\Classes;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ClassExport implements FromView, ShouldAutoSize, WithStyles, WithColumnFormatting, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(int $id)
    {
        $this->classId = $id;
    }

    public function view(): View
    {
        // Fetch student grades by ID
        $classes = Classes::select('*', 'class.id as cid','subject.grade_level AS class_glevel')->join('subject', 'subject.id', '=', 'class.subject_id')->join('student_subject', 'student_subject.subject_id', '=', 'subject.id')->join('student_personal_details', 'student_personal_details.id', '=', 'student_subject.student_id')->join('student_user_mapping', 'student_user_mapping.student_id', '=', 'student_personal_details.id')->join('users', 'users.id', '=', 'student_user_mapping.user_id')->join('student_gradelevel_section', 'student_gradelevel_section.id', '=', 'student_personal_details.glevel_section_id')->join('school_year', 'school_year.id', '=', 'class.sy_id')->where('class.id', $this->classId)->get();
        $classes_sel = Classes::select('*', 'class.id as cid','subject.grade_level AS class_glevel')->join('subject', 'subject.id', '=', 'class.subject_id')->join('school_year', 'school_year.id', '=', 'class.sy_id')->join('faculty_staff_personal_details', 'faculty_staff_personal_details.id', '=', 'class.faculty_id')->where('class.id', $this->classId)->first();
        // Return the collection of student grades
        return view('exports.class', [
            'classes' => $classes,
            'class_sel' => $classes_sel
        ]);
    }
    public function styles(Worksheet $sheet)
    {
        // Format column A as a number without decimal places
        $sheet->getStyle('B')->getNumberFormat()->setFormatCode('0');
        // Change the format code as needed
    }
    public function startCell(): string
    {
        return 'A9'; // Start header after 3 blank cells
    }
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 10,           
        ];
    }

}
