<?php

namespace Tests\Feature\Booking;

use App\Exceptions\BookingUnavailableException;
use App\Models\ClassSchedule;
use App\Models\Location;
use App\Models\OpeningHour;
use App\Models\PilatesClass;
use App\Models\Staff;
use App\Models\Treatment;
use App\Services\Booking\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class BookingServiceTest extends TestCase
{
    use RefreshDatabase;

    private function openLocation(): void
    {
        $location = Location::factory()->create(['is_primary' => true]);

        foreach (range(0, 6) as $day) {
            OpeningHour::factory()->create([
                'location_id' => $location->id,
                'day_of_week' => $day,
                'opens_at' => '08:00:00',
                'closes_at' => '21:00:00',
                'is_closed' => false,
            ]);
        }
    }

    public function test_a_treatment_slot_cannot_be_double_booked_once_every_therapist_is_taken(): void
    {
        $this->openLocation();

        $treatment = Treatment::factory()->create(['duration_minutes' => 60]);
        Staff::factory()->therapist()->create();
        Staff::factory()->therapist()->create();

        $service = app(BookingService::class);
        $date = Carbon::tomorrow()->toDateString();

        $service->bookTreatment($treatment, $date, '10:00:00', ['name' => 'A', 'email' => 'a@example.com']);
        $service->bookTreatment($treatment, $date, '10:00:00', ['name' => 'B', 'email' => 'b@example.com']);

        $this->expectException(BookingUnavailableException::class);
        $service->bookTreatment($treatment, $date, '10:00:00', ['name' => 'C', 'email' => 'c@example.com']);
    }

    public function test_a_class_cannot_be_booked_past_capacity(): void
    {
        $this->openLocation();

        $instructor = Staff::factory()->instructor()->create();
        $class = PilatesClass::factory()->create(['instructor_id' => $instructor->id, 'capacity' => 1]);
        $schedule = ClassSchedule::factory()->create(['pilates_class_id' => $class->id]);

        $service = app(BookingService::class);
        $date = Carbon::tomorrow()->toDateString();

        $service->bookClass($schedule, $date, ['name' => 'A', 'email' => 'a@example.com']);

        $this->expectException(BookingUnavailableException::class);
        $service->bookClass($schedule, $date, ['name' => 'B', 'email' => 'b@example.com']);
    }

    public function test_booking_a_treatment_reuses_an_existing_customer_by_email(): void
    {
        $this->openLocation();

        $treatment = Treatment::factory()->create(['duration_minutes' => 60]);
        Staff::factory()->therapist()->create();

        $service = app(BookingService::class);
        $date = Carbon::tomorrow()->toDateString();

        $first = $service->bookTreatment($treatment, $date, '10:00:00', ['name' => 'A', 'email' => 'same@example.com']);
        $second = $service->bookTreatment($treatment, $date, '11:00:00', ['name' => 'A', 'email' => 'same@example.com']);

        $this->assertSame($first->customer_id, $second->customer_id);
    }
}
