<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectionCandidate extends Model
{
    protected $fillable = [
        'name',
        'office',
        'matric_number',
        'department',
        'level',
        'photo',
        'manifesto',
        'votes',
    ];
}
