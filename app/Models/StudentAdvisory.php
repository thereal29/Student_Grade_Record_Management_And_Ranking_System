<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAdvisory extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'student_advisory';
    protected $fillable = [
        'student_id',
        'adviser_id',
    ];
}
