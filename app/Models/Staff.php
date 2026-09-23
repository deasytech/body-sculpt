<?php

namespace App\Models;

use App\Enums\StaffType;
use Database\Factories\StaffFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'type', 'name', 'email', 'phone', 'bio', 'avatar_path', 'specialties', 'is_active', 'sort_order'])]
class Staff extends Model
{
    /** @use HasFactory<StaffFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'type' => StaffType::class,
            'specialties' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pilatesClasses(): HasMany
    {
        return $this->hasMany(PilatesClass::class, 'instructor_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function blogPosts(): HasMany
    {
        return $this->hasMany(BlogPost::class);
    }

    public function scopeInstructors($query)
    {
        return $query->where('type', StaffType::Instructor);
    }

    public function scopeTherapists($query)
    {
        return $query->where('type', StaffType::Therapist);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
