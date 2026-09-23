<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Location>
 */
class LocationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Body Sculpt Wellness',
            'address_line1' => fake()->streetAddress(),
            'city' => 'Lagos',
            'state' => 'Lagos',
            'country' => 'Nigeria',
            'phone' => fake()->phoneNumber(),
            'email' => 'hello@bodysculptwellness.com',
            'is_primary' => true,
        ];
    }
}
