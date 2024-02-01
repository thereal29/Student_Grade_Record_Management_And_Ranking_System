<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoCurricularSubType extends Model
{
    use HasFactory;
    
    protected $table = 'cocurricular_activity_subtype';
    protected $fillable = [
        'id',
        'subtype',
        'point',
        'parentID',
    ];
}