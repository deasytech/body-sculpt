<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\OpeningHour;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OpeningHour>
 */
class OpeningHourFactory extends Factory
{
    public function definition(): array
    {
        return [
            'location_id' => Location::factory(),
            'day_of_week' => fake()->numberBetween(0, 6),
            'opens_at' => '08:00:00',
            'closes_at' => '21:00:00',
            'is_closed' => false,
        ];
    }
}
