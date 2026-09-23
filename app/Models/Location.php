<?php

namespace App\Models;

use Database\Factories\LocationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name', 'address_line1', 'address_line2', 'city', 'state', 'country',
    'phone', 'email', 'latitude', 'longitude', 'is_primary',
])]
class Location extends Model
{
    /** @use HasFactory<LocationFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function openingHours(): HasMany
    {
        return $this->hasMany(OpeningHour::class);
    }

    public function fullAddress(): string
    {
        return collect([$this->address_line1, $this->address_line2, $this->city, $this->state, $this->country])
            ->filter()
            ->implode(', ');
    }
}
