<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeSection extends Model
{
    use HasFactory;
    protected $table = 'student_gradelevel_section';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'grade_level',
        'section',
    ];
}
