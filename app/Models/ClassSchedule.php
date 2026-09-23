<?php

namespace App\Models;

use Database\Factories\ClassScheduleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable(['pilates_class_id', 'day_of_week', 'start_time', 'end_time', 'capacity_override', 'is_active'])]
class ClassSchedule extends Model
{
    /** @use HasFactory<ClassScheduleFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'day_of_week' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function pilatesClass(): BelongsTo
    {
        return $this->belongsTo(PilatesClass::class);
    }

    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable');
    }

    public function capacity(): int
    {
        return $this->capacity_override ?? $this->pilatesClass->capacity;
    }

    public function dayName(): string
    {
        return ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][$this->day_of_week];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
