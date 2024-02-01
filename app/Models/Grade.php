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
        'student_id',
        'subject_id',
        'sy_id',
        'firstQ',
        'secondQ',
        'thirdQ',
        'fourthQ',
    ];
}
