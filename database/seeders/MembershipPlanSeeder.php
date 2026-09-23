<?php

namespace Database\Seeders;

use App\Enums\BillingInterval;
use App\Models\MembershipPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MembershipPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Essential Membership',
                'price' => 65000,
                'interval' => BillingInterval::Monthly,
                'sessions' => 4,
                'benefits' => [
                    '4 Pilates classes per month',
                    '10% off treatments',
                    'Priority booking',
                ],
            ],
            [
                'name' => 'Signature Membership',
                'price' => 110000,
                'interval' => BillingInterval::Monthly,
                'sessions' => 8,
                'benefits' => [
                    '8 Pilates classes per month',
                    '15% off treatments',
                    'One complimentary recovery add-on monthly',
                    'Priority booking',
                ],
            ],
            [
                'name' => 'Unlimited Membership',
                'price' => 180000,
                'interval' => BillingInterval::Monthly,
                'sessions' => null,
                'benefits' => [
                    'Unlimited Pilates classes',
                    '20% off treatments',
                    'Complimentary sauna & steam access',
                    'Priority booking',
                ],
            ],
            [
                'name' => 'Annual Wellness Membership',
                'price' => 1800000,
                'interval' => BillingInterval::Annual,
                'sessions' => null,
                'benefits' => [
                    'Unlimited Pilates classes for a full year',
                    '20% off treatments',
                    'Two complimentary rituals per quarter',
                    'Priority booking and guest passes',
                ],
            ],
        ];

        foreach ($plans as $index => $data) {
            MembershipPlan::query()->updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'name' => $data['name'],
                    'description' => 'Make wellness a ritual with regular access to Pilates, recovery and treatment benefits.',
                    'price' => $data['price'] * 100,
                    'billing_interval' => $data['interval'],
                    'sessions_included' => $data['sessions'],
                    'benefits' => $data['benefits'],
                    'is_active' => true,
                    'sort_order' => $index,
                ],
            );
        }
    }
}
