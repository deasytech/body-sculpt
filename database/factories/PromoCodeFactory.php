<?php

namespace Database\Factories;

use App\Enums\PromoType;
use App\Models\PromoCode;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PromoCode>
 */
class PromoCodeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => strtoupper(Str::random(8)),
            'type' => PromoType::Percentage,
            'value' => fake()->numberBetween(5, 25),
            'is_active' => true,
        ];
    }
}
