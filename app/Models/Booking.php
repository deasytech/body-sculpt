<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable([
    'customer_id', 'bookable_type', 'bookable_id', 'staff_id', 'booking_date',
    'start_time', 'end_time', 'status', 'price', 'notes', 'cancelled_at',
])]
class Booking extends Model
{
    /** @use HasFactory<BookingFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'status' => BookingStatus::class,
            'booking_date' => 'date',
            'cancelled_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function bookable(): MorphTo
    {
        return $this->morphTo();
    }

    public function serviceName(): string
    {
        if ($this->bookable_type === 'treatment') {
            return $this->bookable?->name ?? 'Treatment';
        }

        /** @var ClassSchedule|null $schedule */
        $schedule = $this->bookable;

        return $schedule?->pilatesClass?->name ?? 'Pilates Class';
    }

    public function scopeUpcoming($query)
    {
        return $query->where('booking_date', '>=', now()->toDateString())
            ->whereNot('status', BookingStatus::Cancelled);
    }

    public function scopeOnDate($query, string $date)
    {
        return $query->whereDate('booking_date', $date);
    }

    public function priceInNaira(): float
    {
        return $this->price / 100;
    }

    public function isCancellable(): bool
    {
        return $this->status !== BookingStatus::Cancelled
            && $this->status !== BookingStatus::Completed
            && ! $this->booking_date->isPast();
    }
}
