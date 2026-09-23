<?php

namespace Database\Factories;

use App\Enums\BillingInterval;
use App\Models\MembershipPlan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<MembershipPlan>
 */
class MembershipPlanFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true).' Membership';

        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween(40000, 250000) * 100,
            'billing_interval' => fake()->randomElement(BillingInterval::cases()),
            'sessions_included' => fake()->randomElement([4, 8, 12, null]),
            'benefits' => fake()->sentences(4),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
