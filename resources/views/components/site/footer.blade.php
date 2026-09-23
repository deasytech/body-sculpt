@php
    $location = \App\Models\Location::query()->where('is_primary', true)->first();
    $openingHours = $location?->openingHours()->orderBy('day_of_week')->get();
@endphp

<footer style="background-color: var(--color-mocha-deep); color: var(--color-cream)">
    <div class="mx-auto max-w-7xl px-5 py-16 sm:px-8">
        <div class="grid gap-12 lg:grid-cols-4">
            <div class="lg:col-span-1">
                <x-site.logo dark />
                <p class="mt-4 text-sm italic opacity-80">&ldquo;{{ \App\Models\Setting::get('tagline', 'Relax your body, mind & spirit.') }}&rdquo;</p>

                <div class="mt-6 flex gap-4">
                    @if ($url = \App\Models\Setting::get('instagram_url'))
                        <a href="{{ $url }}" target="_blank" rel="noopener" class="text-sm opacity-80 hover:opacity-100" aria-label="Instagram">
                            {{ \App\Models\Setting::get('instagram_handle', 'Instagram') }}
                        </a>
                    @endif
                </div>
            </div>

            <div>
                <p class="section-eyebrow" style="color: var(--color-sage)">Explore</p>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="{{ route('about') }}" class="opacity-80 hover:opacity-100">About</a></li>
                    <li><a href="{{ route('pilates') }}" class="opacity-80 hover:opacity-100">Pilates</a></li>
                    <li><a href="{{ route('wellness') }}" class="opacity-80 hover:opacity-100">Wellness</a></li>
                    <li><a href="{{ route('membership') }}" class="opacity-80 hover:opacity-100">Membership</a></li>
                    <li><a href="{{ route('cafe') }}" class="opacity-80 hover:opacity-100">Café</a></li>
                    <li><a href="{{ route('shop') }}" class="opacity-80 hover:opacity-100">Shop</a></li>
                    <li><a href="{{ route('contact') }}" class="opacity-80 hover:opacity-100">Contact</a></li>
                </ul>
            </div>

            <div>
                <p class="section-eyebrow" style="color: var(--color-sage)">Visit</p>
                @if ($location)
                    <address class="mt-4 space-y-1 text-sm not-italic opacity-80">
                        <p>{{ $location->address_line1 }}</p>
                        <p>{{ $location->address_line2 }}</p>
                        <p>{{ $location->city }}, {{ $location->state }}</p>
                    </address>
                    <p class="mt-4 text-sm opacity-80">
                        <a href="tel:{{ preg_replace('/\s+/', '', $location->phone) }}" class="hover:opacity-100">{{ $location->phone }}</a>
                    </p>
                    <p class="text-sm opacity-80">
                        <a href="mailto:{{ $location->email }}" class="hover:opacity-100">{{ $location->email }}</a>
                    </p>
                @endif
            </div>

            <div>
                <p class="section-eyebrow" style="color: var(--color-sage)">Opening Hours</p>
                <ul class="mt-4 space-y-1 text-sm opacity-80">
                    @foreach ($openingHours ?? [] as $hours)
                        <li class="flex justify-between gap-4">
                            <span>{{ $hours->dayName() }}</span>
                            <span>{{ $hours->is_closed ? 'Closed' : \Illuminate\Support\Carbon::parse($hours->opens_at)->format('g:ia').'–'.\Illuminate\Support\Carbon::parse($hours->closes_at)->format('g:ia') }}</span>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-6">
                    <p class="section-eyebrow" style="color: var(--color-sage)">Stay in the loop</p>
                    <p class="mt-2 text-xs opacity-70">Receive wellness news, new classes, treatments and studio updates.</p>
                    @livewire('site.newsletter-form')
                </div>
            </div>
        </div>

        <div class="mt-16 flex flex-col items-center justify-between gap-4 border-t pt-8 text-xs opacity-60 sm:flex-row" style="border-color: color-mix(in srgb, var(--color-cream) 20%, transparent)">
            <p>&copy; {{ now()->year }} Body Sculpt Wellness. All rights reserved.</p>
            <p>Lekki Phase 1, Lagos, Nigeria</p>
        </div>
    </div>
</footer>
