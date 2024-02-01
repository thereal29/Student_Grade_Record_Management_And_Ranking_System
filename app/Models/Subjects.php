<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    use HasFactory;
    protected $table = 'subject';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'subject_name',
    ];
}
