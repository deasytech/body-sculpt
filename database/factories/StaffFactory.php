<?php

namespace Database\Factories;

use App\Enums\StaffType;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Staff>
 */
class StaffFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(StaffType::cases()),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'bio' => fake()->paragraph(),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }

    public function instructor(): static
    {
        return $this->state(['type' => StaffType::Instructor]);
    }

    public function therapist(): static
    {
        return $this->state(['type' => StaffType::Therapist]);
    }
}
