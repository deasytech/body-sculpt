<x-layouts.site title="Pilates" description="Reformer Pilates, Mat Pilates, private and group sessions in Lekki Phase 1, Lagos.">

    <section class="px-5 py-24 sm:px-8" style="background: linear-gradient(160deg, var(--color-sand) 0%, var(--color-cream) 60%)">
        <div class="mx-auto max-w-4xl">
            <p class="reveal section-eyebrow">Pilates</p>
            <h1 class="reveal mt-4 max-w-2xl text-5xl sm:text-6xl" style="color: var(--color-mocha)">Move with intention.</h1>
            <p class="reveal mt-6 max-w-xl text-lg opacity-80">
                Reformer Pilates, Mat Pilates, signature classes, private sessions and group sessions —
                movement built around your body, not the other way around.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-5 py-20 sm:px-8">
        <div class="grid gap-16 sm:grid-cols-2">
            @foreach ($classes as $pilatesClass)
                <div class="reveal">
                    <div class="overflow-hidden rounded-sm">
                        <x-site.image-placeholder :path="$pilatesClass->image_path" :alt="$pilatesClass->name" :label="$pilatesClass->level->label()" class="aspect-[16/10]" />
                    </div>
                    <div class="mt-6 flex items-start justify-between gap-4">
                        <div>
                            <h2 class="font-display text-2xl" style="color: var(--color-mocha)">{{ $pilatesClass->name }}</h2>
                            <p class="mt-2 text-sm opacity-75">{{ $pilatesClass->description }}</p>
                        </div>
                        <span class="shrink-0 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wide" style="background-color: var(--color-sand); color: var(--color-mocha)">
                            {{ $pilatesClass->level->label() }}
                        </span>
                    </div>

                    @if ($pilatesClass->instructor)
                        <p class="mt-3 text-sm" style="color: var(--color-sage-deep)">With {{ $pilatesClass->instructor->name }} · {{ $pilatesClass->duration_minutes }} min · Up to {{ $pilatesClass->capacity }} people</p>
                    @endif

                    @if ($pilatesClass->schedules->isNotEmpty())
                        <ul class="mt-4 flex flex-wrap gap-2 text-xs">
                            @foreach ($pilatesClass->schedules as $schedule)
                                <li class="rounded-full border px-3 py-1" style="border-color: var(--color-sand-deep); color: var(--color-mocha)">
                                    {{ $schedule->dayName() }} · {{ \Illuminate\Support\Carbon::parse($schedule->start_time)->format('g:ia') }}
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <a href="{{ route('book') }}" class="btn-secondary mt-6 inline-flex">Book This Class</a>
                </div>
            @endforeach
        </div>
    </section>

    <section class="px-5 py-24 text-center sm:px-8" style="background-color: var(--color-sand)">
        <x-site.section-heading align="center">Ready to move?</x-site.section-heading>
        <a href="{{ route('book') }}" class="reveal btn-primary mt-8 inline-flex">Book a Session &rarr;</a>
    </section>

</x-layouts.site>
