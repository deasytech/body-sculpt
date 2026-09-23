<?php

namespace Database\Factories;

use App\Models\ClassSchedule;
use App\Models\PilatesClass;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ClassSchedule>
 */
class ClassScheduleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'pilates_class_id' => PilatesClass::factory(),
            'day_of_week' => fake()->numberBetween(1, 6),
            'start_time' => '09:00:00',
            'end_time' => '09:50:00',
            'is_active' => true,
        ];
    }
}
