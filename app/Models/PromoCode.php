<?php

namespace App\Models;

use App\Enums\PromoType;
use Database\Factories\PromoCodeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['code', 'type', 'value', 'max_uses', 'used_count', 'starts_at', 'expires_at', 'is_active'])]
class PromoCode extends Model
{
    /** @use HasFactory<PromoCodeFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'type' => PromoType::class,
            'starts_at' => 'date',
            'expires_at' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function isValid(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if ($this->max_uses !== null && $this->used_count >= $this->max_uses) {
            return false;
        }

        $today = now()->toDateString();

        if ($this->starts_at && $today < $this->starts_at->toDateString()) {
            return false;
        }

        if ($this->expires_at && $today > $this->expires_at->toDateString()) {
            return false;
        }

        return true;
    }

    public function discountFor(int $subtotal): int
    {
        return match ($this->type) {
            PromoType::Percentage => (int) round($subtotal * ($this->value / 100)),
            PromoType::Fixed => min($this->value, $subtotal),
        };
    }
}
