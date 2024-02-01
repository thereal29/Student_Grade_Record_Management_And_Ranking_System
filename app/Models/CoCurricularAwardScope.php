<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoCurricularAwardScope extends Model
{
    use HasFactory;
    
    protected $table = 'cocurricular_activity_award_scope';
    protected $fillable = [
        'id',
        'award_scope',
        'point',
        'parentID',
    ];
}