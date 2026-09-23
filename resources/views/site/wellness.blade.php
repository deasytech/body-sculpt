<x-layouts.site title="Wellness" description="Recovery Rituals, Sculpt Treatments, Facial Treatments and Heat & Recovery — the full Body Sculpt Wellness menu.">

    @if ($faqs->isNotEmpty())
        @php
            $faqSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => $faqs->map(fn ($faq) => [
                    '@type' => 'Question',
                    'name' => $faq->question,
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq->answer,
                    ],
                ])->all(),
            ];
        @endphp
        @push('schema')
            <script type="application/ld+json">{!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES) !!}</script>
        @endpush
    @endif

    <section class="px-5 py-24 sm:px-8" style="background: linear-gradient(160deg, var(--color-sand) 0%, var(--color-cream) 60%)">
        <div class="mx-auto max-w-4xl text-center">
            <p class="reveal section-eyebrow">Wellness Rituals</p>
            <h1 class="reveal mt-4 text-5xl sm:text-6xl" style="color: var(--color-mocha)">Your body deserves a reset.</h1>
            <p class="reveal mt-6 text-sm uppercase tracking-[0.3em]" style="color: var(--color-sage-deep)">Move &rarr; Recover &rarr; Restore</p>
        </div>
    </section>

    {{-- Wellness Menu --}}
    <section class="mx-auto max-w-7xl px-5 py-20 sm:px-8">
        @foreach ($categories as $category)
            @if ($category->treatments->isNotEmpty())
                <div class="mb-20">
                    <x-site.section-heading :eyebrow="$category->name">{{ $category->description }}</x-site.section-heading>

                    <div class="mt-10 divide-y" style="border-color: var(--color-sand-deep)">
                        @foreach ($category->treatments as $treatment)
                            <a href="{{ route('treatments.show', $treatment) }}" class="reveal group flex items-center justify-between gap-6 py-6">
                                <div>
                                    <h3 class="font-display text-xl transition-colors group-hover:opacity-70" style="color: var(--color-mocha)">{{ $treatment->name }}</h3>
                                    <p class="mt-1 max-w-lg text-sm opacity-70">{{ $treatment->short_description }}</p>
                                    <p class="mt-1 text-xs uppercase tracking-wide" style="color: var(--color-sage-deep)">{{ $treatment->duration_minutes }} minutes</p>
                                </div>
                                <div class="shrink-0 text-right">
                                    <p class="font-display text-lg" style="color: var(--color-mocha)">₦{{ number_format($treatment->priceInNaira()) }}</p>
                                    <span class="text-xs font-semibold uppercase tracking-wide" style="color: var(--color-sage-deep)">Book &rarr;</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </section>

    @if ($faqs->isNotEmpty())
        <section class="px-5 py-24 sm:px-8" style="background-color: var(--color-sand)">
            <div class="mx-auto max-w-3xl">
                <x-site.section-heading eyebrow="Good to Know" align="center">Frequently asked questions.</x-site.section-heading>

                <div class="mt-12 space-y-3">
                    @foreach ($faqs as $faq)
                        <details class="reveal group rounded-sm border p-5" style="border-color: var(--color-sand-deep); background-color: var(--color-cream)">
                            <summary class="cursor-pointer list-none font-display text-lg" style="color: var(--color-mocha)">
                                {{ $faq->question }}
                            </summary>
                            <p class="mt-3 text-sm opacity-80">{{ $faq->answer }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="px-5 py-24 text-center sm:px-8">
        <a href="{{ route('book') }}" class="reveal btn-primary inline-flex">Book a Session &rarr;</a>
    </section>

</x-layouts.site>
