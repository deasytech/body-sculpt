<?php

namespace App\Models;

use App\Enums\ClassLevel;
use Database\Factories\PilatesClassFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'instructor_id', 'name', 'slug', 'description', 'level',
    'duration_minutes', 'capacity', 'image_path', 'is_active', 'sort_order',
])]
class PilatesClass extends Model
{
    /** @use HasFactory<PilatesClassFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'level' => ClassLevel::class,
            'is_active' => 'boolean',
        ];
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'instructor_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(ClassSchedule::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
