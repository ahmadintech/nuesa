<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicResource extends Model
{
    protected $fillable = [
        'title',
        'category',
        'course_code',
        'department_id',
        'file_path',
        'external_link',
        'file_size',
        'downloads_count',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
