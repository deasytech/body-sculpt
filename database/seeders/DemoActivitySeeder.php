<?php

namespace Database\Seeders;

use App\Enums\BookingStatus;
use App\Enums\MembershipStatus;
use App\Enums\OrderStatus;
use App\Models\Booking;
use App\Models\ClassSchedule;
use App\Models\Customer;
use App\Models\Membership;
use App\Models\MembershipPlan;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Staff;
use App\Models\Treatment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoActivitySeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::factory()->count(18)->create();

        $treatments = Treatment::all();
        $schedules = ClassSchedule::with('pilatesClass')->get();
        $therapists = Staff::therapists()->get();

        // Recent + upcoming treatment bookings against real therapists (respects one-slot-per-therapist).
        foreach (range(-10, 10) as $offset) {
            $customer = $customers->random();
            $treatment = $treatments->random();
            $therapist = $therapists->random();
            $date = now()->addDays($offset);
            $hour = [9, 11, 13, 15, 17][abs($offset) % 5];

            Booking::query()->create([
                'customer_id' => $customer->id,
                'bookable_type' => 'treatment',
                'bookable_id' => $treatment->id,
                'staff_id' => $therapist->id,
                'booking_date' => $date->toDateString(),
                'start_time' => sprintf('%02d:00:00', $hour),
                'end_time' => $date->copy()->setTime($hour, 0)->addMinutes($treatment->duration_minutes)->format('H:i:s'),
                'status' => $offset < 0 ? BookingStatus::Completed : ($offset === 0 ? BookingStatus::Confirmed : BookingStatus::Pending),
                'price' => $treatment->price,
            ]);
        }

        // Pilates class seat bookings against real weekly schedules.
        foreach ($schedules as $schedule) {
            $seats = random_int(1, max(1, min(6, $schedule->capacity())));
            $nextDate = now()->next($schedule->day_of_week);

            foreach (range(1, $seats) as $i) {
                Booking::query()->create([
                    'customer_id' => $customers->random()->id,
                    'bookable_type' => 'class_schedule',
                    'bookable_id' => $schedule->id,
                    'booking_date' => $nextDate->toDateString(),
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'status' => BookingStatus::Confirmed,
                    'price' => 15000 * 100,
                ]);
            }
        }

        // Memberships for a subset of customers.
        $plans = MembershipPlan::all();
        foreach ($customers->take(8) as $customer) {
            Membership::query()->create([
                'customer_id' => $customer->id,
                'membership_plan_id' => $plans->random()->id,
                'status' => MembershipStatus::Active,
                'starts_at' => now()->subMonths(random_int(0, 6)),
                'ends_at' => now()->addMonths(random_int(1, 6)),
            ]);
        }

        // A handful of shop orders.
        $products = Product::all();
        foreach ($customers->take(10) as $customer) {
            $lineItems = $products->random(random_int(1, 3));
            $subtotal = 0;

            $order = Order::query()->create([
                'customer_id' => $customer->id,
                'order_number' => 'BSW-'.strtoupper(Str::random(8)),
                'status' => collect(OrderStatus::cases())->random(),
                'subtotal' => 0,
                'discount' => 0,
                'total' => 0,
            ]);

            foreach ($lineItems as $product) {
                $quantity = random_int(1, 2);
                $lineTotal = $product->price * $quantity;
                $subtotal += $lineTotal;

                OrderItem::query()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'line_total' => $lineTotal,
                ]);
            }

            $order->update(['subtotal' => $subtotal, 'total' => $subtotal]);
        }
    }
}
