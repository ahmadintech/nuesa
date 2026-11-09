<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'role',
        'matric_number',
        'department_id',
        'academic_class',
        'phone',
        'state_of_origin',
        'dues_status',
        'clearance_status',
        'barcode_hash',
        'password',
        'profile_photo_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function isStaff(): bool
    {
        return in_array($this->role, ['admin', 'executive'], true)
            || $this->hasAnyRole(['admin', 'executive']);
    }

    public function hasVoted(): bool
    {
        return ElectionBallot::where('user_id', $this->id)->exists();
    }
}
