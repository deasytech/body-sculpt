<?php

namespace App\Enums;

enum MembershipStatus: string
{
    case Active = 'active';
    case Expiring = 'expiring';
    case Expired = 'expired';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Expiring => 'Expiring Soon',
            self::Expired => 'Expired',
            self::Cancelled => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Active => 'success',
            self::Expiring => 'warning',
            self::Expired => 'danger',
            self::Cancelled => 'gray',
        };
    }

    public function fluxColor(): string
    {
        return match ($this) {
            self::Active => 'emerald',
            self::Expiring => 'amber',
            self::Expired => 'red',
            self::Cancelled => 'zinc',
        };
    }
}
