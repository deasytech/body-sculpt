@php
    use App\Models\Setting;

    $content = App\Filament\Pages\HomeContent::defaults();
    $get = fn (string $key) => Setting::get($key, $content[$key] ?? null);
@endphp
<x-layouts.site :title="null" :description="$get('home_hero_subheading')" :image="$get('home_hero_image')">

    {{-- Hero --}}
    <section class="relative flex min-h-[85vh] items-center overflow-hidden">
        <x-site.image-placeholder :path="$get('home_hero_image')" alt="Inside the Body Sculpt Wellness studio" class="absolute inset-0 h-full w-full" :priority="true" />
        <div class="absolute inset-0" style="background: linear-gradient(100deg, color-mix(in srgb, var(--color-mocha-deep) 88%, transparent) 0%, color-mix(in srgb, var(--color-mocha-deep) 55%, transparent) 45%, color-mix(in srgb, var(--color-mocha-deep) 20%, transparent) 100%)"></div>

        <div class="relative mx-auto max-w-7xl px-5 py-24 sm:px-8">
            <p class="section-eyebrow reveal" style="color: var(--color-sage)">Body Sculpt Wellness · Lekki Phase 1, Lagos</p>
            <h1 class="reveal mt-5 max-w-3xl text-5xl leading-[1.05] sm:text-7xl" style="color: var(--color-cream); white-space: pre-line">{{ $get('home_hero_heading') }}</h1>
            <p class="reveal mt-6 max-w-xl text-lg" style="color: var(--color-cream); opacity: 0.85">
                {{ $get('home_hero_subheading') }}
            </p>
            <div class="reveal mt-10 flex flex-wrap gap-4">
                <a href="{{ route('book') }}" class="btn-primary">{{ $get('home_hero_cta_primary') }} &rarr;</a>
                <a href="{{ route('wellness') }}" class="inline-flex items-center justify-center gap-2 rounded-sm border px-7 py-3.5 text-sm font-semibold tracking-wide uppercase transition-colors duration-300" style="border-color: var(--color-cream); color: var(--color-cream)">{{ $get('home_hero_cta_secondary') }}</a>
            </div>
        </div>
    </section>

    {{-- Brand introduction --}}
    <section class="mx-auto max-w-5xl px-5 py-24 text-center sm:px-8">
        <x-site.section-heading eyebrow="Our Philosophy" align="center">
            Wellness, thoughtfully reimagined.
        </x-site.section-heading>
        <p class="reveal mx-auto mt-8 max-w-2xl text-lg opacity-80">
            Body Sculpt is more than fitness. It's movement, recovery, beauty, self-care and restoration —
            a place to strengthen the body, quiet the mind, and step away from the noise of daily life.
        </p>
    </section>

    {{-- Services / Experiences --}}
    <section class="px-5 py-24 sm:px-8" style="background-color: var(--color-sand)">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading eyebrow="The Experience">Five ways to restore.</x-site.section-heading>

            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-5">
                <a href="{{ route('pilates') }}" class="reveal group block">
                    <x-site.image-placeholder :path="$get('home_tile_pilates_image')" alt="Pilates" label="Pilates" class="aspect-square rounded-sm transition-transform duration-700 group-hover:scale-105" />
                    <h3 class="mt-4 font-display text-lg" style="color: var(--color-mocha)">Pilates</h3>
                    <p class="mt-1 text-sm opacity-70">Reformer Pilates, Mat Pilates, movement and strength.</p>
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('wellness') }}" class="reveal group block">
                        <x-site.image-placeholder :path="$get('home_tile_'.str($category->slug)->replace('-', '_').'_image')" :alt="$category->name" :label="$category->name" class="aspect-square rounded-sm transition-transform duration-700 group-hover:scale-105" />
                        <h3 class="mt-4 font-display text-lg" style="color: var(--color-mocha)">{{ $category->name }}</h3>
                        <p class="mt-1 text-sm opacity-70">{{ $category->description }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Pilates preview --}}
    <section class="mx-auto max-w-7xl px-5 py-24 sm:px-8">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-site.section-heading eyebrow="Pilates">{{ $get('home_pilates_heading') }}</x-site.section-heading>
            <a href="{{ route('pilates') }}" class="reveal text-sm font-semibold uppercase tracking-wide" style="color: var(--color-mocha)">Explore Pilates &rarr;</a>
        </div>

        <div class="mt-14 grid gap-8 sm:grid-cols-3">
            @foreach ($featuredClasses as $pilatesClass)
                <x-site.class-card :pilates-class="$pilatesClass" />
            @endforeach
        </div>
    </section>

    {{-- Wellness Rituals --}}
    <section class="px-5 py-24 sm:px-8" style="background-color: var(--color-mocha)">
        <div class="mx-auto max-w-7xl">
            <p class="reveal section-eyebrow" style="color: var(--color-sage)">Wellness Rituals</p>
            <h2 class="reveal mt-3 max-w-xl text-4xl sm:text-5xl" style="color: var(--color-cream)">{{ $get('home_wellness_heading') }}</h2>
            <p class="reveal mt-6 max-w-xl text-sm uppercase tracking-[0.3em]" style="color: var(--color-sage)">{{ $get('home_wellness_tagline') }}</p>

            <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($recoveryRituals->take(4) as $treatment)
                    <a href="{{ route('treatments.show', $treatment) }}" class="reveal group block">
                        <x-site.image-placeholder :path="$treatment->image_path" :alt="$treatment->name" class="aspect-[3/4] rounded-sm transition-transform duration-700 group-hover:scale-105" />
                        <h3 class="mt-4 font-display text-lg" style="color: var(--color-cream)">{{ $treatment->name }}</h3>
                        <p class="mt-1 text-sm" style="color: var(--color-sage)">{{ $treatment->duration_minutes }} min · ₦{{ number_format($treatment->priceInNaira()) }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Body Sculpting --}}
    <section class="mx-auto max-w-7xl px-5 py-24 sm:px-8">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-site.section-heading eyebrow="Sculpt">{{ $get('home_sculpt_heading') }}</x-site.section-heading>
            <a href="{{ route('wellness') }}" class="reveal text-sm font-semibold uppercase tracking-wide" style="color: var(--color-mocha)">View Wellness Menu &rarr;</a>
        </div>

        <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($sculptTreatments->take(4) as $treatment)
                <x-site.treatment-card :treatment="$treatment" />
            @endforeach
        </div>
    </section>

    {{-- Facials --}}
    <section class="px-5 py-24 sm:px-8" style="background-color: var(--color-sand)">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading eyebrow="Facials">{{ $get('home_facials_heading') }}</x-site.section-heading>

            <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($facials->take(4) as $treatment)
                    <x-site.treatment-card :treatment="$treatment" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- The Body Sculpt Experience --}}
    <section class="mx-auto max-w-7xl px-5 py-24 sm:px-8">
        <div class="grid items-center gap-14 lg:grid-cols-2">
            <div class="reveal grid grid-cols-2 gap-4">
                <x-site.image-placeholder :path="$get('home_experience_image_1')" alt="Inside the studio" class="aspect-[3/4] rounded-sm" />
                <x-site.image-placeholder :path="$get('home_experience_image_2')" alt="A wellness ritual" class="mt-8 aspect-[3/4] rounded-sm" />
            </div>
            <div>
                <x-site.section-heading eyebrow="The Body Sculpt Experience">{{ $get('home_experience_heading') }}</x-site.section-heading>
                <p class="reveal mt-6 max-w-md text-base opacity-80">
                    {{ $get('home_experience_copy') }}
                </p>
                <a href="{{ route('about') }}" class="reveal btn-secondary mt-8 inline-flex">Learn More</a>
            </div>
        </div>
    </section>

    {{-- Membership --}}
    <section class="px-5 py-24 sm:px-8" style="background-color: var(--color-mocha-deep)">
        <div class="mx-auto max-w-7xl">
            <div class="text-center">
                <p class="reveal section-eyebrow" style="color: var(--color-sage)">Membership</p>
                <h2 class="reveal mx-auto mt-3 max-w-xl text-4xl sm:text-5xl" style="color: var(--color-cream)">{{ $get('home_membership_heading') }}</h2>
            </div>

            <div class="mt-14 grid gap-8 lg:grid-cols-3">
                @foreach ($membershipPlans as $index => $plan)
                    <x-site.membership-card :plan="$plan" :featured="$index === 1" />
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('membership') }}" class="reveal text-sm font-semibold uppercase tracking-wide" style="color: var(--color-sage)">Explore Memberships &rarr;</a>
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    @if ($testimonials->isNotEmpty())
        <section class="mx-auto max-w-7xl px-5 py-24 sm:px-8">
            <x-site.section-heading eyebrow="From Our Clients" align="center">{{ $get('home_testimonials_heading') }}</x-site.section-heading>

            <div class="mt-14 grid gap-6 sm:grid-cols-2">
                @foreach ($testimonials as $testimonial)
                    <x-site.testimonial-card :testimonial="$testimonial" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- Final CTA --}}
    <section class="px-5 py-28 text-center sm:px-8" style="background-color: var(--color-sand-deep)">
        <h2 class="reveal font-display mx-auto max-w-2xl text-4xl sm:text-5xl" style="color: var(--color-mocha)">
            {{ $get('home_cta_heading') }}
        </h2>
        <p class="reveal mx-auto mt-6 max-w-xl text-base opacity-80">
            {{ $get('home_cta_copy') }}
        </p>
        <a href="{{ route('book') }}" class="reveal btn-primary mt-10 inline-flex">Book a Session &rarr;</a>
    </section>

</x-layouts.site>
