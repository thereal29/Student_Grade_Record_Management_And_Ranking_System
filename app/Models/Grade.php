<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $table = 'grades_per_subject';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'student_subject_id',
        'grade_level',
        'firstQ',
        'statusFirstQ',
        'date_submitted_firstQ',
        'date_approved_firstQ',
        'secondQ',
        'statusSecondQ',
        'date_submitted_secondQ',
        'date_approved_secondQ',
        'thirdQ',
        'statusThirdQ',
        'date_submitted_thirdQ',
        'date_approved_thirdQ',
        'fourthQ',
        'statusFourthQ',
        'date_submitted_fourthQ',
        'date_approved_fourthQ',
        'cumulative_gpa',
    ];
}
