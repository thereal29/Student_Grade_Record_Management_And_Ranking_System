<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    use HasFactory;
    protected $table = 'school_year';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'from_year',
        'to_year',
        'quarter',
        'isCurrent',
    ];
}
