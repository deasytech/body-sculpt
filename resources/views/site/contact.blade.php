<x-layouts.site title="Contact" description="Get in touch with Body Sculpt Wellness — Lekki Phase 1, Lagos.">

    <section class="px-5 py-24 sm:px-8" style="background: linear-gradient(160deg, var(--color-sand) 0%, var(--color-cream) 60%)">
        <div class="mx-auto max-w-4xl text-center">
            <p class="reveal section-eyebrow">Contact</p>
            <h1 class="reveal mt-4 text-5xl sm:text-6xl" style="color: var(--color-mocha)">We'd love to hear from you.</h1>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-5 py-20 sm:px-8">
        <div class="grid gap-16 lg:grid-cols-2">
            <div class="reveal">
                <h2 class="font-display text-2xl" style="color: var(--color-mocha)">Send a message</h2>
                <div class="mt-6">
                    @livewire('site.contact-form')
                </div>
            </div>

            <div class="reveal">
                <h2 class="font-display text-2xl" style="color: var(--color-mocha)">Visit the studio</h2>

                @if ($location)
                    <div class="mt-6 space-y-4 text-sm opacity-80">
                        <p>{{ $location->fullAddress() }}</p>
                        <p><a href="tel:{{ preg_replace('/\s+/', '', $location->phone) }}" class="underline">{{ $location->phone }}</a></p>
                        <p><a href="mailto:{{ $location->email }}" class="underline">{{ $location->email }}</a></p>
                    </div>

                    <div class="mt-8">
                        <p class="section-eyebrow">Opening Hours</p>
                        <ul class="mt-3 space-y-1 text-sm opacity-80">
                            @foreach ($location->openingHours()->orderBy('day_of_week')->get() as $hours)
                                <li class="flex justify-between gap-4">
                                    <span>{{ $hours->dayName() }}</span>
                                    <span>{{ $hours->is_closed ? 'Closed' : \Illuminate\Support\Carbon::parse($hours->opens_at)->format('g:ia').'–'.\Illuminate\Support\Carbon::parse($hours->closes_at)->format('g:ia') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mt-8 overflow-hidden rounded-sm">
                    <x-site.image-placeholder label="Map" class="aspect-[4/3]" />
                </div>
            </div>
        </div>
    </section>

</x-layouts.site>
