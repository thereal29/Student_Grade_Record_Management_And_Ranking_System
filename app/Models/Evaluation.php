<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    protected $table = 'character_evaluation';
    protected $fillable = [
        'id',
        'sy_id',
        'status',
    ];
}
