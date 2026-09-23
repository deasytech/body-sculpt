@php
    $treatmentBreadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Wellness', 'item' => route('wellness')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $treatment->name, 'item' => route('treatments.show', $treatment)],
        ],
    ];

    $treatmentServiceSchema = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $treatment->name,
        'description' => $treatment->short_description,
        'serviceType' => $treatment->category?->name,
        'provider' => [
            '@type' => 'HealthAndBeautyBusiness',
            'name' => \App\Models\Setting::get('site_name', config('app.name')),
            'url' => url('/'),
        ],
        'areaServed' => 'Lagos, Nigeria',
        'offers' => [
            '@type' => 'Offer',
            'price' => $treatment->priceInNaira(),
            'priceCurrency' => 'NGN',
            'url' => route('treatments.show', $treatment),
            'availability' => 'https://schema.org/InStock',
        ],
    ]);
@endphp

@push('schema')
    <script type="application/ld+json">{!! json_encode($treatmentBreadcrumbSchema, JSON_UNESCAPED_SLASHES) !!}</script>
    <script type="application/ld+json">{!! json_encode($treatmentServiceSchema, JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

<x-layouts.site :title="$treatment->name" :description="$treatment->short_description" :image="$treatment->image_path">

    <section class="mx-auto max-w-6xl px-5 py-16 sm:px-8">
        <p class="reveal text-sm">
            <a href="{{ route('wellness') }}" class="opacity-70 hover:opacity-100" style="color: var(--color-mocha)">&larr; Wellness Menu</a>
        </p>

        <div class="mt-8 grid gap-12 lg:grid-cols-2">
            <div class="reveal overflow-hidden rounded-sm">
                <x-site.image-placeholder :path="$treatment->image_path" :alt="$treatment->name" :label="$treatment->category?->name" class="aspect-[4/5]" />
            </div>

            <div>
                <p class="section-eyebrow reveal">{{ $treatment->category?->name }}</p>
                <h1 class="reveal mt-3 text-4xl sm:text-5xl" style="color: var(--color-mocha)">{{ $treatment->name }}</h1>
                <p class="reveal mt-6 text-lg opacity-80">{{ $treatment->description }}</p>

                <div class="reveal mt-8 flex gap-8 text-sm">
                    <div>
                        <p class="section-eyebrow">Duration</p>
                        <p class="mt-1 font-display text-xl" style="color: var(--color-mocha)">{{ $treatment->duration_minutes }} min</p>
                    </div>
                    <div>
                        <p class="section-eyebrow">Investment</p>
                        <p class="mt-1 font-display text-xl" style="color: var(--color-mocha)">₦{{ number_format($treatment->priceInNaira()) }}</p>
                    </div>
                </div>

                <a href="{{ route('book') }}" class="btn-primary reveal mt-10 inline-flex">Book This Treatment &rarr;</a>
            </div>
        </div>
    </section>

    @if ($related->isNotEmpty())
        <section class="px-5 py-20 sm:px-8" style="background-color: var(--color-sand)">
            <div class="mx-auto max-w-7xl">
                <x-site.section-heading eyebrow="You May Also Like">More from {{ $treatment->category?->name }}.</x-site.section-heading>

                <div class="mt-12 grid gap-8 sm:grid-cols-3">
                    @foreach ($related as $item)
                        <x-site.treatment-card :treatment="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</x-layouts.site>
