<?php

namespace Database\Factories;

use App\Enums\MembershipStatus;
use App\Models\Customer;
use App\Models\Membership;
use App\Models\MembershipPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Membership>
 */
class MembershipFactory extends Factory
{
    public function definition(): array
    {
        $startsAt = fake()->dateTimeBetween('-6 months', 'now');

        return [
            'customer_id' => Customer::factory(),
            'membership_plan_id' => MembershipPlan::factory(),
            'status' => MembershipStatus::Active,
            'starts_at' => $startsAt,
            'ends_at' => (clone $startsAt)->modify('+1 year'),
        ];
    }
}
