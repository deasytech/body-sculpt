<div class="mx-auto max-w-4xl px-5 py-16 sm:px-8">

    <div class="text-center">
        <p class="section-eyebrow">Book a Session</p>
        <h1 class="mt-3 text-4xl sm:text-5xl" style="color: var(--color-mocha)">Let's find your time.</h1>
    </div>

    {{-- Progress --}}
    <div class="mt-10 flex items-center justify-center gap-2">
        @foreach (range(1, 6) as $i)
            <span class="h-1.5 w-10 rounded-full" style="background-color: {{ $i <= $step ? 'var(--color-mocha)' : 'var(--color-sand-deep)' }}"></span>
        @endforeach
    </div>

    <div class="mt-12">
        {{-- Step 1: Choose type --}}
        @if ($step === 1)
            <div class="grid gap-6 sm:grid-cols-2">
                <button wire:click="chooseType('treatment')" type="button" class="rounded-sm border p-8 text-left transition-colors hover:border-transparent hover:text-white" style="border-color: var(--color-sand-deep)" onmouseover="this.style.backgroundColor='var(--color-mocha)'" onmouseout="this.style.backgroundColor='transparent'">
                    <h2 class="font-display text-2xl" style="color: inherit">A Treatment or Ritual</h2>
                    <p class="mt-2 text-sm opacity-70">Recovery, sculpt, facials, sauna &amp; steam.</p>
                </button>
                <button wire:click="chooseType('class')" type="button" class="rounded-sm border p-8 text-left transition-colors hover:border-transparent hover:text-white" style="border-color: var(--color-sand-deep)" onmouseover="this.style.backgroundColor='var(--color-mocha)'" onmouseout="this.style.backgroundColor='transparent'">
                    <h2 class="font-display text-2xl" style="color: inherit">A Pilates Class</h2>
                    <p class="mt-2 text-sm opacity-70">Reformer, mat, private and group sessions.</p>
                </button>
            </div>
        @endif

        {{-- Step 2: Choose item --}}
        @if ($step === 2)
            <div>
                @if ($bookableType === 'treatment')
                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach ($this->treatments as $treatment)
                            <button wire:click="chooseTreatment({{ $treatment->id }})" type="button" class="rounded-sm border p-5 text-left" style="border-color: var(--color-sand-deep); {{ $treatmentId === $treatment->id ? 'background-color: var(--color-sand);' : '' }}">
                                <p class="font-display text-lg" style="color: var(--color-mocha)">{{ $treatment->name }}</p>
                                <p class="mt-1 text-xs opacity-70">{{ $treatment->category?->name }} · {{ $treatment->duration_minutes }} min · ₦{{ number_format($treatment->priceInNaira()) }}</p>
                            </button>
                        @endforeach
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach ($this->pilatesClasses as $pilatesClass)
                            <div>
                                <p class="font-display text-lg" style="color: var(--color-mocha)">{{ $pilatesClass->name }}</p>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @forelse ($pilatesClass->schedules as $schedule)
                                        <button wire:click="chooseSchedule({{ $schedule->id }})" type="button" class="rounded-full border px-4 py-1.5 text-xs" style="border-color: var(--color-sand-deep); {{ $scheduleId === $schedule->id ? 'background-color: var(--color-mocha); color: var(--color-cream);' : 'color: var(--color-mocha);' }}">
                                            {{ $schedule->dayName() }} {{ \Illuminate\Support\Carbon::parse($schedule->start_time)->format('g:ia') }}
                                        </button>
                                    @empty
                                        <p class="text-xs opacity-50">No scheduled sessions yet.</p>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <button wire:click="back" type="button" class="mt-8 text-sm underline opacity-70">Back</button>
            </div>
        @endif

        {{-- Step 3: Choose date --}}
        @if ($step === 3)
            <div>
                <div class="flex flex-wrap gap-3">
                    @forelse ($this->availableDates as $option)
                        <button wire:click="chooseDate('{{ $option }}')" type="button" class="rounded-sm border px-4 py-3 text-sm" style="border-color: var(--color-sand-deep); {{ $date === $option ? 'background-color: var(--color-mocha); color: var(--color-cream);' : 'color: var(--color-mocha);' }}">
                            {{ \Illuminate\Support\Carbon::parse($option)->format('D, M j') }}
                        </button>
                    @empty
                        <p class="text-sm opacity-70">No upcoming dates available — please check back soon or contact us directly.</p>
                    @endforelse
                </div>

                <button wire:click="back" type="button" class="mt-8 text-sm underline opacity-70">Back</button>
            </div>
        @endif

        {{-- Step 4: Choose time (treatments only) --}}
        @if ($step === 4)
            <div>
                <div class="flex flex-wrap gap-3">
                    @forelse ($this->availableSlots as $slot)
                        <button wire:click="chooseTime('{{ $slot['time'] }}')" type="button" class="rounded-sm border px-4 py-3 text-sm" style="border-color: var(--color-sand-deep); {{ $time === $slot['time'] ? 'background-color: var(--color-mocha); color: var(--color-cream);' : 'color: var(--color-mocha);' }}">
                            {{ \Illuminate\Support\Carbon::parse($slot['time'])->format('g:ia') }}
                        </button>
                    @empty
                        <p class="text-sm opacity-70">No times available on this date — please choose another date.</p>
                    @endforelse
                </div>

                <button wire:click="back" type="button" class="mt-8 text-sm underline opacity-70">Back</button>
            </div>
        @endif

        {{-- Step 5: Customer details --}}
        @if ($step === 5)
            <form wire:submit="confirm" class="space-y-5">
                <div class="rounded-sm border p-5 text-sm" style="border-color: var(--color-sand-deep); background-color: var(--color-sand)">
                    <p class="font-semibold" style="color: var(--color-mocha)">
                        @if ($bookableType === 'treatment')
                            {{ $this->selectedTreatment()?->name }}
                        @else
                            {{ $this->selectedSchedule()?->pilatesClass?->name }}
                        @endif
                    </p>
                    <p class="mt-1 opacity-70">{{ \Illuminate\Support\Carbon::parse($date)->format('l, F j') }} @if($time) at {{ \Illuminate\Support\Carbon::parse($time)->format('g:ia') }} @endif</p>
                </div>

                @if ($errorMessage)
                    <p class="rounded-sm bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errorMessage }}</p>
                @endif

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide" style="color: var(--color-mocha)">Name</label>
                        <input type="text" wire:model="name" class="w-full rounded-sm border px-3 py-2.5 text-sm" style="border-color: var(--color-sand-deep)">
                        @error('name') <p class="mt-1 text-xs text-red-700">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide" style="color: var(--color-mocha)">Email</label>
                        <input type="email" wire:model="email" class="w-full rounded-sm border px-3 py-2.5 text-sm" style="border-color: var(--color-sand-deep)">
                        @error('email') <p class="mt-1 text-xs text-red-700">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide" style="color: var(--color-mocha)">Phone</label>
                    <input type="tel" wire:model="phone" class="w-full rounded-sm border px-3 py-2.5 text-sm" style="border-color: var(--color-sand-deep)">
                    @error('phone') <p class="mt-1 text-xs text-red-700">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide" style="color: var(--color-mocha)">Notes (optional)</label>
                    <textarea rows="3" wire:model="notes" class="w-full rounded-sm border px-3 py-2.5 text-sm" style="border-color: var(--color-sand-deep)"></textarea>
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="confirm">
                        <span wire:loading.remove wire:target="confirm">Confirm Booking</span>
                        <span wire:loading wire:target="confirm">Booking…</span>
                    </button>
                    <button wire:click="back" type="button" class="text-sm underline opacity-70">Back</button>
                </div>
            </form>
        @endif

        {{-- Step 6: Confirmation --}}
        @if ($step === 6 && $this->confirmedBooking())
            <div class="rounded-sm border p-10 text-center" style="border-color: var(--color-sand-deep); background-color: var(--color-sand)">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12" style="color: var(--color-sage-deep)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z" /></svg>
                <h2 class="mt-4 font-display text-2xl" style="color: var(--color-mocha)">You're booked.</h2>
                <p class="mt-2 text-sm opacity-80">
                    {{ \Illuminate\Support\Carbon::parse($this->confirmedBooking()->booking_date)->format('l, F j') }}
                    at {{ \Illuminate\Support\Carbon::parse($this->confirmedBooking()->start_time)->format('g:ia') }}
                </p>
                <p class="mt-1 text-xs opacity-60">A confirmation has been sent to {{ $this->confirmedBooking()->customer->email }}.</p>
                <a href="{{ route('home') }}" class="btn-secondary mt-8 inline-flex">Back to Home</a>
            </div>
        @endif
    </div>
</div>
