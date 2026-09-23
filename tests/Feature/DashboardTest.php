<?php

namespace Tests\Feature;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_visit_the_dashboard(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('dashboard'));
        $response->assertOk();
    }

    public function test_dashboard_shows_the_users_own_upcoming_bookings(): void
    {
        $user = User::factory()->create(['email' => 'jane@example.com']);
        $customer = Customer::factory()->create(['email' => 'jane@example.com']);
        $someoneElse = Customer::factory()->create();

        $ownBooking = Booking::factory()->for($customer)->create([
            'booking_date' => now()->addDay()->toDateString(),
            'status' => BookingStatus::Confirmed,
        ]);
        Booking::factory()->for($someoneElse)->create([
            'booking_date' => now()->addDay()->toDateString(),
            'status' => BookingStatus::Confirmed,
        ]);

        $this->actingAs($user);

        Livewire::test('App\\Livewire\\Account\\Dashboard')
            ->assertSee($ownBooking->serviceName())
            ->assertDontSee($someoneElse->name);
    }

    public function test_a_user_can_cancel_their_own_upcoming_booking(): void
    {
        $user = User::factory()->create(['email' => 'jane@example.com']);
        $customer = Customer::factory()->create(['email' => 'jane@example.com']);

        $booking = Booking::factory()->for($customer)->create([
            'booking_date' => now()->addDay()->toDateString(),
            'status' => BookingStatus::Confirmed,
        ]);

        $this->actingAs($user);

        Livewire::test('App\\Livewire\\Account\\Dashboard')
            ->call('cancelBooking', $booking->id);

        $this->assertSame(BookingStatus::Cancelled, $booking->fresh()->status);
    }

    public function test_a_user_cannot_cancel_another_customers_booking(): void
    {
        $user = User::factory()->create(['email' => 'jane@example.com']);
        Customer::factory()->create(['email' => 'jane@example.com']);
        $someoneElse = Customer::factory()->create();

        $booking = Booking::factory()->for($someoneElse)->create([
            'booking_date' => now()->addDay()->toDateString(),
            'status' => BookingStatus::Confirmed,
        ]);

        $this->actingAs($user);

        Livewire::test('App\\Livewire\\Account\\Dashboard')
            ->call('cancelBooking', $booking->id)
            ->assertForbidden();

        $this->assertSame(BookingStatus::Confirmed, $booking->fresh()->status);
    }
}
