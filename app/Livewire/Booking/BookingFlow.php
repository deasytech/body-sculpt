<?php

namespace App\Livewire\Booking;

use App\Exceptions\BookingUnavailableException;
use App\Models\Booking;
use App\Models\ClassSchedule;
use App\Models\PilatesClass;
use App\Models\Treatment;
use App\Services\Booking\AvailabilityService;
use App\Services\Booking\BookingService;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.site')]
#[Title('Book a Session')]
class BookingFlow extends Component
{
    use WithRateLimiting;

    public int $step = 1;

    /** 'treatment' | 'class' */
    public string $bookableType = '';

    public ?int $treatmentId = null;

    public ?int $pilatesClassId = null;

    public ?int $scheduleId = null;

    public ?string $date = null;

    public ?string $time = null;

    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $notes = '';

    public ?int $confirmedBookingId = null;

    public ?string $errorMessage = null;

    #[Computed]
    public function treatments(): Collection
    {
        return Treatment::query()->active()->with('category')->orderBy('sort_order')->get();
    }

    #[Computed]
    public function pilatesClasses(): Collection
    {
        return PilatesClass::query()->active()->with(['instructor', 'schedules' => fn ($q) => $q->active()->orderBy('day_of_week')])->orderBy('sort_order')->get();
    }

    #[Computed]
    public function selectedTreatment(): ?Treatment
    {
        return $this->treatmentId ? Treatment::find($this->treatmentId) : null;
    }

    #[Computed]
    public function selectedSchedule(): ?ClassSchedule
    {
        return $this->scheduleId ? ClassSchedule::with('pilatesClass')->find($this->scheduleId) : null;
    }

    #[Computed]
    public function availableDates(): Collection
    {
        if ($this->bookableType === 'treatment') {
            return collect(range(0, 20))->map(fn ($i) => now()->addDays($i)->toDateString());
        }

        if ($this->bookableType === 'class' && $this->selectedSchedule()) {
            return app(AvailabilityService::class)
                ->upcomingOccurrences($this->selectedSchedule(), 8)
                ->filter(fn ($o) => $o['seats_remaining'] > 0)
                ->pluck('date');
        }

        return collect();
    }

    #[Computed]
    public function availableSlots(): Collection
    {
        if ($this->bookableType !== 'treatment' || ! $this->selectedTreatment() || ! $this->date) {
            return collect();
        }

        return app(AvailabilityService::class)->treatmentSlots($this->selectedTreatment(), $this->date);
    }

    public function chooseType(string $type): void
    {
        $this->bookableType = $type;
        $this->step = 2;
    }

    public function chooseTreatment(int $id): void
    {
        $this->treatmentId = $id;
        $this->date = null;
        $this->time = null;
        $this->step = 3;
    }

    public function chooseSchedule(int $scheduleId): void
    {
        $this->scheduleId = $scheduleId;
        $this->date = null;
        $this->step = 3;
    }

    public function chooseDate(string $date): void
    {
        if (! $this->availableDates()->contains($date)) {
            return;
        }

        $this->date = $date;
        $this->time = null;

        $this->step = $this->bookableType === 'treatment' ? 4 : 5;
    }

    public function chooseTime(string $time): void
    {
        if (! $this->availableSlots()->pluck('time')->contains($time)) {
            return;
        }

        $this->time = $time;
        $this->step = 5;
    }

    public function back(): void
    {
        $this->errorMessage = null;
        $this->step = max(1, $this->step - 1);
    }

    public function confirm(BookingService $bookingService): void
    {
        $this->errorMessage = null;

        try {
            $this->rateLimit(5, decaySeconds: 60);
        } catch (TooManyRequestsException $exception) {
            $this->errorMessage = "Too many attempts. Please try again in {$exception->secondsUntilAvailable} seconds.";

            return;
        }

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
        ]);

        $customerData = ['name' => $this->name, 'email' => $this->email, 'phone' => $this->phone];

        try {
            if ($this->bookableType === 'treatment') {
                $booking = $bookingService->bookTreatment(
                    $this->selectedTreatment(),
                    $this->date,
                    $this->time,
                    $customerData,
                    $this->notes ?: null,
                );
            } else {
                $booking = $bookingService->bookClass(
                    $this->selectedSchedule(),
                    $this->date,
                    $customerData,
                    $this->notes ?: null,
                );
            }
        } catch (BookingUnavailableException $e) {
            $this->errorMessage = $e->getMessage();

            return;
        }

        $this->confirmedBookingId = $booking->id;
        $this->step = 6;
    }

    #[Computed]
    public function confirmedBooking(): ?Booking
    {
        return $this->confirmedBookingId
            ? Booking::with(['customer', 'staff'])->find($this->confirmedBookingId)
            : null;
    }
}
