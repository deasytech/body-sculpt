<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        $subtotal = fake()->numberBetween(15000, 80000) * 100;

        return [
            'customer_id' => Customer::factory(),
            'order_number' => 'BSW-'.strtoupper(Str::random(8)),
            'status' => fake()->randomElement(OrderStatus::cases()),
            'subtotal' => $subtotal,
            'discount' => 0,
            'total' => $subtotal,
        ];
    }
}
