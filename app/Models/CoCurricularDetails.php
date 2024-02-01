<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoCurricularDetails extends Model
{
    use HasFactory;
    protected $table = 'co_curricular_activity_details';
    protected $fillable = [
        'student_id',
        'cocurricular_id',
        'status',
        'status_update_date',
        'partialtotalPoints',
        'proof',
    ];
    protected $casts = [
        'studentID' => 'integer',
        'temp' => 'integer',
    ];
}
