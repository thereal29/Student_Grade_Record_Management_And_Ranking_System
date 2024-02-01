<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoCurricular extends Model
{
    use HasFactory;
    protected $table = 'co_curricular_activity';
    protected $fillable = [
        'id',
        'typeID',
        'subtypeID',
        'award_scopeID',
    ];
}
