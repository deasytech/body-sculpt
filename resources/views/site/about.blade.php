@php
    use App\Models\Setting;

    $content = App\Filament\Pages\AboutContent::defaults();
    $get = fn (string $key) => Setting::get($key, $content[$key] ?? null);

    $values = [
        ['label' => 'Movement', 'description' => 'Reformer and mat Pilates that builds strength with intention, not intensity for its own sake.'],
        ['label' => 'Recovery', 'description' => 'Massage, sauna and steam rituals that give the body real time to restore.'],
        ['label' => 'Beauty', 'description' => 'Hydrafacials and skin treatments rooted in glow, not gimmicks.'],
        ['label' => 'Self-care', 'description' => 'A café, a shop, a space to linger — wellness as a rhythm, not an errand.'],
    ];
@endphp
<x-layouts.site title="About" :description="$get('about_hero_subheading')" :image="$get('about_hero_image')">

    {{-- Hero --}}
    <section class="relative flex min-h-[60vh] items-end overflow-hidden">
        <x-site.image-placeholder :path="$get('about_hero_image')" alt="Inside the Body Sculpt Wellness studio" class="absolute inset-0 h-full w-full" :priority="true" />
        <div class="absolute inset-0" style="background: linear-gradient(0deg, color-mix(in srgb, var(--color-mocha-deep) 92%, transparent) 0%, color-mix(in srgb, var(--color-mocha-deep) 40%, transparent) 60%, color-mix(in srgb, var(--color-mocha-deep) 15%, transparent) 100%)"></div>

        <div class="relative mx-auto max-w-4xl px-5 py-16 text-center sm:px-8">
            <p class="reveal section-eyebrow" style="color: var(--color-sage)">About Us</p>
            <h1 class="reveal mt-4 text-5xl sm:text-6xl" style="color: var(--color-cream)">
                {{ $page->title ?? 'About Body Sculpt Wellness' }}
            </h1>
            <p class="reveal mx-auto mt-6 max-w-xl text-lg" style="color: var(--color-cream); opacity: 0.9">
                {{ $get('about_hero_subheading') }}
            </p>
        </div>
    </section>

    {{-- Our Story --}}
    <section class="mx-auto max-w-7xl px-5 py-24 sm:px-8">
        <div class="grid items-center gap-14 lg:grid-cols-2">
            <div class="reveal order-2 lg:order-1">
                <x-site.section-heading eyebrow="Our Story">{{ $get('about_story_heading') }}</x-site.section-heading>
                <div class="prose mt-8 max-w-none text-lg leading-relaxed opacity-90" style="color: var(--color-charcoal)">
                    @foreach (explode("\n\n", $page->content ?? '') as $paragraph)
                        <p class="mb-6">{{ $paragraph }}</p>
                    @endforeach
                </div>
            </div>
            <x-site.image-placeholder :path="$get('about_story_image')" alt="A Pilates session at Body Sculpt Wellness" class="reveal order-1 aspect-[4/5] rounded-sm lg:order-2" />
        </div>
    </section>

    {{-- Values --}}
    <section class="px-5 py-24 sm:px-8" style="background-color: var(--color-sand)">
        <div class="mx-auto max-w-7xl">
            <x-site.section-heading eyebrow="Our Philosophy" align="center">{{ $get('about_values_heading') }}</x-site.section-heading>

            <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($values as $value)
                    <div class="reveal text-center">
                        <span class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full" style="background-color: var(--color-cream); color: var(--color-sage-deep)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456Z" /></svg>
                        </span>
                        <h3 class="font-display text-lg" style="color: var(--color-mocha)">{{ $value['label'] }}</h3>
                        <p class="mt-2 text-sm opacity-75">{{ $value['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Life at the Studio --}}
    <section class="mx-auto max-w-7xl px-5 py-24 sm:px-8">
        <x-site.section-heading eyebrow="The Studio" align="center">{{ $get('about_gallery_heading') }}</x-site.section-heading>

        <div class="mt-14 grid gap-6 sm:grid-cols-2">
            <x-site.image-placeholder :path="$get('about_gallery_image_1')" alt="A treatment at Body Sculpt Wellness" class="reveal aspect-[4/5] rounded-sm" />
            <x-site.image-placeholder :path="$get('about_gallery_image_2')" alt="Heat and recovery at Body Sculpt Wellness" class="reveal mt-8 aspect-[4/5] rounded-sm sm:mt-0 sm:mb-8" />
        </div>
    </section>

    {{-- Team --}}
    @if ($team->isNotEmpty())
        <section class="px-5 py-24 sm:px-8" style="background-color: var(--color-sand)">
            <div class="mx-auto max-w-7xl">
                <x-site.section-heading eyebrow="Our Team" align="center">{{ $get('about_team_heading') }}</x-site.section-heading>

                <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($team as $member)
                        <div class="reveal text-center">
                            <x-site.image-placeholder :path="$member->avatar_path" :alt="$member->name" class="aspect-square rounded-full" />
                            <h3 class="mt-4 font-display text-lg" style="color: var(--color-mocha)">{{ $member->name }}</h3>
                            <p class="text-sm" style="color: var(--color-sage-deep)">{{ $member->type->label() }}</p>
                            @if ($member->bio)
                                <p class="mt-2 text-sm opacity-70">{{ $member->bio }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="px-5 py-28 text-center sm:px-8">
        <x-site.section-heading align="center">{{ $get('about_cta_heading') }}</x-site.section-heading>
        <a href="{{ route('book') }}" class="reveal btn-primary mt-10 inline-flex">Book a Session &rarr;</a>
    </section>

</x-layouts.site>
