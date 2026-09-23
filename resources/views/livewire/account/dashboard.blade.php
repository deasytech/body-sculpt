<div class="flex w-full flex-1 flex-col gap-8">
        <div>
            <flux:heading size="xl" level="1">{{ __('Welcome back, :name', ['name' => explode(' ', auth()->user()->name)[0]]) }}</flux:heading>
            <flux:subheading size="lg">{{ __('Your account, membership and appointments in one place.') }}</flux:subheading>
        </div>

        {{-- Account & membership --}}
        <div class="grid gap-4 md:grid-cols-2">
            <flux:card class="space-y-3">
                <flux:heading>{{ __('Your details') }}</flux:heading>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="text-zinc-500">{{ __('Name') }}</dt>
                        <dd class="font-medium">{{ auth()->user()->name }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-zinc-500">{{ __('Email') }}</dt>
                        <dd class="font-medium">{{ auth()->user()->email }}</dd>
                    </div>
                    @if ($this->customer?->phone)
                        <div class="flex justify-between gap-4">
                            <dt class="text-zinc-500">{{ __('Phone') }}</dt>
                            <dd class="font-medium">{{ $this->customer->phone }}</dd>
                        </div>
                    @endif
                    <div class="flex justify-between gap-4">
                        <dt class="text-zinc-500">{{ __('Member since') }}</dt>
                        <dd class="font-medium">{{ auth()->user()->created_at?->format('M Y') }}</dd>
                    </div>
                </dl>
                <flux:button :href="route('profile.edit')" variant="ghost" size="sm" wire:navigate>
                    {{ __('Edit details') }}
                </flux:button>
            </flux:card>

            <flux:card class="space-y-3">
                <flux:heading>{{ __('Membership') }}</flux:heading>
                @if ($this->membership)
                    <div class="flex items-center justify-between">
                        <span class="font-medium">{{ $this->membership->plan->name }}</span>
                        <flux:badge :color="$this->membership->status->fluxColor()" size="sm">
                            {{ $this->membership->status->label() }}
                        </flux:badge>
                    </div>
                    @if ($this->membership->ends_at)
                        <flux:text size="sm">
                            {{ __('Renews :date', ['date' => $this->membership->ends_at->format('j M Y')]) }}
                        </flux:text>
                    @endif
                @else
                    <flux:text size="sm">{{ __("You don't have an active membership yet.") }}</flux:text>
                    <flux:button :href="route('membership')" variant="primary" size="sm" wire:navigate>
                        {{ __('Explore Memberships') }}
                    </flux:button>
                @endif
            </flux:card>
        </div>

        {{-- Upcoming appointments --}}
        <div>
            <div class="mb-4 flex items-center justify-between">
                <flux:heading size="lg">{{ __('Upcoming appointments') }}</flux:heading>
                <flux:button :href="route('book')" variant="primary" size="sm" wire:navigate>
                    {{ __('Book a Session') }}
                </flux:button>
            </div>

            @if ($this->upcomingBookings->isEmpty())
                <flux:card class="text-center">
                    <flux:text>{{ __("You don't have any upcoming appointments.") }}</flux:text>
                </flux:card>
            @else
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($this->upcomingBookings as $booking)
                        <flux:card class="space-y-3" wire:key="upcoming-{{ $booking->id }}">
                            <div class="flex items-start justify-between gap-3">
                                <flux:heading class="text-base">{{ $booking->serviceName() }}</flux:heading>
                                <flux:badge :color="$booking->status->fluxColor()" size="sm">
                                    {{ $booking->status->label() }}
                                </flux:badge>
                            </div>
                            <div class="space-y-1 text-sm text-zinc-500">
                                <p>{{ $booking->booking_date->format('l, j M Y') }}</p>
                                <p>{{ \Illuminate\Support\Carbon::parse($booking->start_time)->format('g:ia') }} &ndash; {{ \Illuminate\Support\Carbon::parse($booking->end_time)->format('g:ia') }}</p>
                                @if ($booking->staff)
                                    <p>{{ __('With :name', ['name' => $booking->staff->name]) }}</p>
                                @endif
                            </div>
                            @if ($booking->isCancellable())
                                <flux:button
                                    variant="danger"
                                    size="sm"
                                    wire:click="cancelBooking({{ $booking->id }})"
                                    wire:confirm="{{ __('Cancel this appointment? This cannot be undone.') }}"
                                >
                                    {{ __('Cancel') }}
                                </flux:button>
                            @endif
                        </flux:card>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Appointment history --}}
        @if ($this->pastBookings->isNotEmpty())
            <div>
                <flux:heading size="lg" class="mb-4">{{ __('Appointment history') }}</flux:heading>

                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>{{ __('Service') }}</flux:table.column>
                        <flux:table.column>{{ __('Date') }}</flux:table.column>
                        <flux:table.column>{{ __('Price') }}</flux:table.column>
                        <flux:table.column>{{ __('Status') }}</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @foreach ($this->pastBookings as $booking)
                            <flux:table.row wire:key="past-{{ $booking->id }}">
                                <flux:table.cell>{{ $booking->serviceName() }}</flux:table.cell>
                                <flux:table.cell>{{ $booking->booking_date->format('j M Y') }}</flux:table.cell>
                                <flux:table.cell>&#8358;{{ number_format($booking->priceInNaira()) }}</flux:table.cell>
                                <flux:table.cell>
                                    <flux:badge :color="$booking->status->fluxColor()" size="sm">
                                        {{ $booking->status->label() }}
                                    </flux:badge>
                                </flux:table.cell>
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
            </div>
        @endif
    </div>
