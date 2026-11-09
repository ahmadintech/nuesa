<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAlbum extends Model
{
    protected $fillable = [
        'student_name',
        'student_id_number',
        'department_id',
        'academic_class',
        'position_role',
        'phone',
        'email',
        'state_of_origin',
        'joined_date',
        'verification_status',
        'filter_tag',
        'image_path',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
