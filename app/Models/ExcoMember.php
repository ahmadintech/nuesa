<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExcoMember extends Model
{
    protected $fillable = [
        'name',
        'office_position',
        'department_id',
        'academic_session',
        'twitter_handle',
        'linkedin_url',
        'photo_path',
        'sort_order',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderByRaw("
            CASE 
                WHEN LOWER(office_position) LIKE '%president%' AND LOWER(office_position) NOT LIKE '%vice%' THEN 1
                ELSE 2
            END ASC, id ASC
        ");
    }
}
