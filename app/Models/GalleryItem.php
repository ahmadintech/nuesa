<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryItem extends Model
{
    protected $fillable = [
        'title',
        'category',
        'department_id',
        'academic_set',
        'student_role',
        'student_id_number',
        'verification_status',
        'image_path',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
