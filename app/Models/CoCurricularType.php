<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoCurricularType extends Model
{
    use HasFactory;
    
    protected $table = 'cocurricular_activity_type';
    protected $fillable = [
        'id',
        'type_of_activity',
    ];
}