<?php

namespace App\Models;

use Database\Factories\OpeningHourFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['location_id', 'day_of_week', 'opens_at', 'closes_at', 'is_closed'])]
class OpeningHour extends Model
{
    /** @use HasFactory<OpeningHourFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_closed' => 'boolean',
        ];
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function dayName(): string
    {
        return ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][$this->day_of_week];
    }
}
