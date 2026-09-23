<?php

namespace App\Services\Booking;

use App\Enums\BookingStatus;
use App\Exceptions\BookingUnavailableException;
use App\Models\Booking;
use App\Models\ClassSchedule;
use App\Models\Customer;
use App\Models\Setting;
use App\Models\Staff;
use App\Models\Treatment;
use App\Models\User;
use App\Notifications\BookingConfirmed;
use App\Notifications\NewBookingReceived;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class BookingService
{
    /**
     * @param  array{name: string, email: string, phone?: string}  $customerData
     */
    public function bookTreatment(Treatment $treatment, string $date, string $startTime, array $customerData, ?string $notes = null): Booking
    {
        $booking = DB::transaction(function () use ($treatment, $date, $startTime, $customerData, $notes) {
            $endTime = date('H:i:s', strtotime($startTime.' +'.$treatment->duration_minutes.' minutes'));

            $therapists = Staff::query()->therapists()->active()->get();

            $conflicting = Booking::query()
                ->onDate($date)
                ->whereNotNull('staff_id')
                ->whereIn('staff_id', $therapists->pluck('id'))
                ->whereNot('status', BookingStatus::Cancelled)
                ->where('start_time', '<', $endTime)
                ->where('end_time', '>', $startTime)
                ->lockForUpdate()
                ->pluck('staff_id');

            $availableTherapist = $therapists->first(fn (Staff $staff) => ! $conflicting->contains($staff->id));

            if (! $availableTherapist) {
                throw BookingUnavailableException::slotTaken();
            }

            $customer = Customer::query()->firstOrCreate(
                ['email' => $customerData['email']],
                ['name' => $customerData['name'], 'phone' => $customerData['phone'] ?? null],
            );

            return Booking::query()->create([
                'customer_id' => $customer->id,
                'bookable_type' => 'treatment',
                'bookable_id' => $treatment->id,
                'staff_id' => $availableTherapist->id,
                'booking_date' => $date,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'status' => BookingStatus::Pending,
                'price' => $treatment->price,
                'notes' => $notes,
            ]);
        });

        $this->notifyOfBooking($booking);

        return $booking;
    }

    /**
     * @param  array{name: string, email: string, phone?: string}  $customerData
     */
    public function bookClass(ClassSchedule $schedule, string $date, array $customerData, ?string $notes = null): Booking
    {
        $booking = DB::transaction(function () use ($schedule, $date, $customerData, $notes) {
            $booked = Booking::query()
                ->where('bookable_type', 'class_schedule')
                ->where('bookable_id', $schedule->id)
                ->onDate($date)
                ->whereNot('status', BookingStatus::Cancelled)
                ->lockForUpdate()
                ->count();

            if ($booked >= $schedule->capacity()) {
                throw BookingUnavailableException::classFull();
            }

            $customer = Customer::query()->firstOrCreate(
                ['email' => $customerData['email']],
                ['name' => $customerData['name'], 'phone' => $customerData['phone'] ?? null],
            );

            return Booking::query()->create([
                'customer_id' => $customer->id,
                'bookable_type' => 'class_schedule',
                'bookable_id' => $schedule->id,
                'booking_date' => $date,
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
                'status' => BookingStatus::Pending,
                'price' => (int) Setting::get('pilates_drop_in_price', 1500000),
                'notes' => $notes,
            ]);
        });

        $this->notifyOfBooking($booking);

        return $booking;
    }

    public function cancel(Booking $booking): void
    {
        $booking->update([
            'status' => BookingStatus::Cancelled,
            'cancelled_at' => now(),
        ]);
    }

    private function notifyOfBooking(Booking $booking): void
    {
        $booking->customer->notify(new BookingConfirmed($booking));

        $admins = User::query()->where('is_admin', true)->get();

        if ($admins->isNotEmpty()) {
            Notification::send($admins, new NewBookingReceived($booking));
        }
    }
}
