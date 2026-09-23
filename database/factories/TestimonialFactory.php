<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_name' => fake()->firstName().' '.fake()->randomLetter().'.',
            'quote' => fake()->paragraph(2),
            'rating' => 5,
            'is_featured' => false,
            'is_active' => true,
        ];
    }
}
