<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassAdvisory extends Model
{
    use HasFactory;
    protected $table = 'class_advisory';
    protected $fillable = [
        'id',
        'faculty_id',
        'glevel_section_id',
    ];
}
