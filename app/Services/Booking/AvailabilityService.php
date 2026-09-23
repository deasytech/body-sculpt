<?php

namespace App\Services\Booking;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\ClassSchedule;
use App\Models\Location;
use App\Models\Staff;
use App\Models\Treatment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Single source of truth for computing bookable time slots, shared by the
 * public booking flow and the Filament admin so both agree on what's open.
 */
class AvailabilityService
{
    /**
     * Time slots for a treatment on a given date, one entry per slot the
     * business is open, each carrying the therapist who would be assigned.
     *
     * @return Collection<int, array{time: string, staff: Staff}>
     */
    public function treatmentSlots(Treatment $treatment, string $date): Collection
    {
        $window = $this->openingWindow($date);

        if ($window === null) {
            return collect();
        }

        $therapists = Staff::query()->therapists()->active()->get();

        if ($therapists->isEmpty()) {
            return collect();
        }

        $existing = Booking::query()
            ->onDate($date)
            ->whereNotNull('staff_id')
            ->whereNot('status', BookingStatus::Cancelled)
            ->get(['staff_id', 'start_time', 'end_time']);

        $slots = collect();
        $cursor = $window['opens_at']->copy();

        while ($cursor->copy()->addMinutes($treatment->duration_minutes)->lte($window['closes_at'])) {
            $slotStart = $cursor->format('H:i:s');
            $slotEnd = $cursor->copy()->addMinutes($treatment->duration_minutes)->format('H:i:s');

            $availableTherapist = $therapists->first(function (Staff $therapist) use ($existing, $slotStart, $slotEnd) {
                return ! $existing->contains(function (Booking $booking) use ($therapist, $slotStart, $slotEnd) {
                    return $booking->staff_id === $therapist->id
                        && $slotStart < $booking->end_time
                        && $slotEnd > $booking->start_time;
                });
            });

            if ($availableTherapist && $this->isFuture($date, $slotStart)) {
                $slots->push(['time' => $slotStart, 'staff' => $availableTherapist]);
            }

            $cursor->addMinutes(30);
        }

        return $slots;
    }

    /**
     * Remaining seats for a class schedule occurrence on a given date.
     */
    public function classSeatsRemaining(ClassSchedule $schedule, string $date): int
    {
        $booked = Booking::query()
            ->where('bookable_type', 'class_schedule')
            ->where('bookable_id', $schedule->id)
            ->onDate($date)
            ->whereNot('status', BookingStatus::Cancelled)
            ->count();

        return max(0, $schedule->capacity() - $booked);
    }

    /**
     * The next N upcoming dated occurrences of a class schedule with seats remaining.
     *
     * @return Collection<int, array{date: string, seats_remaining: int}>
     */
    public function upcomingOccurrences(ClassSchedule $schedule, int $count = 4): Collection
    {
        $occurrences = collect();
        $cursor = Carbon::today();

        while ($occurrences->count() < $count && $cursor->lt(Carbon::today()->addDays(60))) {
            if ((int) $cursor->dayOfWeek === (int) $schedule->day_of_week && $this->isFuture($cursor->toDateString(), $schedule->start_time)) {
                $occurrences->push([
                    'date' => $cursor->toDateString(),
                    'seats_remaining' => $this->classSeatsRemaining($schedule, $cursor->toDateString()),
                ]);
            }

            $cursor->addDay();
        }

        return $occurrences;
    }

    /**
     * @return array{opens_at: Carbon, closes_at: Carbon}|null
     */
    private function openingWindow(string $date): ?array
    {
        $location = Location::query()->where('is_primary', true)->first();

        if (! $location) {
            return null;
        }

        $dayOfWeek = Carbon::parse($date)->dayOfWeek;
        $hours = $location->openingHours()->where('day_of_week', $dayOfWeek)->first();

        if (! $hours || $hours->is_closed || ! $hours->opens_at || ! $hours->closes_at) {
            return null;
        }

        return [
            'opens_at' => Carbon::parse($date.' '.$hours->opens_at),
            'closes_at' => Carbon::parse($date.' '.$hours->closes_at),
        ];
    }

    private function isFuture(string $date, string $time): bool
    {
        return Carbon::parse($date.' '.$time)->greaterThan(now());
    }
}
