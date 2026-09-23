<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Confirmed => 'Confirmed',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Confirmed => 'success',
            self::Completed => 'info',
            self::Cancelled => 'danger',
        };
    }

    public function fluxColor(): string
    {
        return match ($this) {
            self::Pending => 'amber',
            self::Confirmed => 'emerald',
            self::Completed => 'sky',
            self::Cancelled => 'red',
        };
    }
}
