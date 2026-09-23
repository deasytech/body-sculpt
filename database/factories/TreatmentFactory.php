<?php

namespace Database\Factories;

use App\Models\ServiceCategory;
use App\Models\Treatment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Treatment>
 */
class TreatmentFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'service_category_id' => ServiceCategory::factory(),
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'short_description' => fake()->sentence(),
            'description' => fake()->paragraphs(2, true),
            'duration_minutes' => fake()->randomElement([30, 45, 60, 75, 90]),
            'price' => fake()->numberBetween(15000, 90000) * 100,
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
