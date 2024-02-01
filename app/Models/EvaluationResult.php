<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationResult extends Model
{
    use HasFactory;
    protected $table = 'character_evaluation_results';
    protected $fillable = [
        'id',
        'sy_id',
        'status',
    ];
}
