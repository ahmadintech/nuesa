<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectionBallot extends Model
{
    protected $fillable = ['user_id', 'submitted_at'];

    protected function casts(): array
    {
        return ['submitted_at' => 'datetime'];
    }
}
