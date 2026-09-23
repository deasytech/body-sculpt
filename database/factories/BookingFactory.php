<?php

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Treatment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->time('H:00');

        return [
            'customer_id' => Customer::factory(),
            'bookable_type' => 'treatment',
            'bookable_id' => Treatment::factory(),
            'booking_date' => fake()->dateTimeBetween('-2 weeks', '+2 weeks')->format('Y-m-d'),
            'start_time' => $start,
            'end_time' => date('H:i:s', strtotime($start.' +60 minutes')),
            'status' => fake()->randomElement(BookingStatus::cases()),
            'price' => fake()->numberBetween(15000, 90000) * 100,
        ];
    }
}
