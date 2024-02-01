<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationIndicator extends Model
{
    use HasFactory;
    protected $table = 'character_evaluation_indicator';
    protected $fillable = [
        'id',
        'eval_id',
        'description',
    ];
}
