<?php

namespace App\Livewire\Account;

use App\Models\Booking;
use App\Models\ClassSchedule;
use App\Models\Customer;
use App\Models\Membership;
use App\Models\Treatment;
use App\Services\Booking\BookingService;
use Flux\Flux;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    #[Computed]
    public function customer(): ?Customer
    {
        return Customer::query()->where('email', Auth::user()->email)->first();
    }

    #[Computed]
    public function membership(): ?Membership
    {
        return $this->customer?->activeMembership();
    }

    /** @return Collection<int, Booking> */
    #[Computed]
    public function upcomingBookings(): Collection
    {
        return $this->bookingsQuery()
            ?->upcoming()
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get() ?? collect();
    }

    /** @return Collection<int, Booking> */
    #[Computed]
    public function pastBookings(): Collection
    {
        return $this->bookingsQuery()
            ?->where(fn ($query) => $query
                ->where('booking_date', '<', now()->toDateString())
                ->orWhere('status', 'cancelled'))
            ->orderByDesc('booking_date')
            ->orderByDesc('start_time')
            ->limit(20)
            ->get() ?? collect();
    }

    public function cancelBooking(int $bookingId, BookingService $bookingService): void
    {
        $booking = $this->bookingsQuery()?->whereKey($bookingId)->first();

        abort_if($booking === null || ! $booking->isCancellable(), 403);

        $bookingService->cancel($booking);

        Flux::toast(variant: 'success', text: __('Booking cancelled.'));
    }

    private function bookingsQuery()
    {
        if (! $this->customer) {
            return null;
        }

        return Booking::query()
            ->where('customer_id', $this->customer->id)
            ->with([
                'staff',
                'bookable' => fn ($morphTo) => $morphTo->morphWith([
                    ClassSchedule::class => ['pilatesClass'],
                    Treatment::class => [],
                ]),
            ]);
    }

    public function render()
    {
        return view('livewire.account.dashboard');
    }
}
