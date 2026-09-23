<?php

namespace Tests\Feature\Booking;

use App\Livewire\Booking\BookingFlow;
use App\Models\Booking;
use App\Models\ClassSchedule;
use App\Models\Location;
use App\Models\OpeningHour;
use App\Models\PilatesClass;
use App\Models\Staff;
use App\Models\Treatment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class BookingFlowTest extends TestCase
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

    public function test_a_visitor_can_book_a_treatment_end_to_end(): void
    {
        Notification::fake();

        $this->openLocation();
        $treatment = Treatment::factory()->create(['duration_minutes' => 60]);
        Staff::factory()->therapist()->create();

        $date = now()->addDays(2)->toDateString();

        Livewire::test(BookingFlow::class)
            ->call('chooseType', 'treatment')
            ->assertSet('step', 2)
            ->call('chooseTreatment', $treatment->id)
            ->assertSet('step', 3)
            ->call('chooseDate', $date)
            ->assertSet('step', 4)
            ->call('chooseTime', '10:00:00')
            ->assertSet('step', 5)
            ->set('name', 'Jane Doe')
            ->set('email', 'jane@example.com')
            ->set('phone', '08000000000')
            ->call('confirm')
            ->assertSet('step', 6)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('bookings', [
            'bookable_type' => 'treatment',
            'bookable_id' => $treatment->id,
        ]);
        $this->assertSame($date, Booking::first()->booking_date->toDateString());
    }

    public function test_a_visitor_can_book_a_pilates_class_end_to_end(): void
    {
        Notification::fake();

        $this->openLocation();
        $instructor = Staff::factory()->instructor()->create();
        $class = PilatesClass::factory()->create(['instructor_id' => $instructor->id]);
        $schedule = ClassSchedule::factory()->create(['pilates_class_id' => $class->id]);

        Livewire::test(BookingFlow::class)
            ->call('chooseType', 'class')
            ->call('chooseSchedule', $schedule->id)
            ->assertSet('step', 3)
            ->call('chooseDate', $this->firstOccurrence($schedule))
            ->assertSet('step', 5)
            ->set('name', 'John Smith')
            ->set('email', 'john@example.com')
            ->set('phone', '08000000001')
            ->call('confirm')
            ->assertSet('step', 6)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('bookings', [
            'bookable_type' => 'class_schedule',
            'bookable_id' => $schedule->id,
        ]);
    }

    public function test_validation_errors_are_shown_for_missing_customer_details(): void
    {
        $this->openLocation();
        $treatment = Treatment::factory()->create();
        Staff::factory()->therapist()->create();

        Livewire::test(BookingFlow::class)
            ->call('chooseType', 'treatment')
            ->call('chooseTreatment', $treatment->id)
            ->call('chooseDate', now()->addDay()->toDateString())
            ->call('chooseTime', '10:00:00')
            ->set('email', 'not-an-email')
            ->call('confirm')
            ->assertHasErrors(['name', 'email', 'phone']);
    }

    private function firstOccurrence(ClassSchedule $schedule): string
    {
        $date = now()->addDay();

        while ((int) $date->dayOfWeek !== (int) $schedule->day_of_week) {
            $date = $date->addDay();
        }

        return $date->toDateString();
    }
}
