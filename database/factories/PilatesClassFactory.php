<?php

namespace Database\Factories;

use App\Enums\ClassLevel;
use App\Models\PilatesClass;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PilatesClass>
 */
class PilatesClassFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true).' Pilates';

        return [
            'instructor_id' => Staff::factory()->instructor(),
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'level' => fake()->randomElement(ClassLevel::cases()),
            'duration_minutes' => 50,
            'capacity' => 12,
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
