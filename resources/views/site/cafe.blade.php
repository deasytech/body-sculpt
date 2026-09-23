@php
    use App\Models\Setting;

    $content = App\Filament\Pages\CafeContent::defaults();
    $get = fn (string $key) => Setting::get($key, $content[$key] ?? null);
@endphp
<x-layouts.site title="Café" :description="$get('cafe_hero_copy')">

    <section class="px-5 py-24 sm:px-8" style="background: linear-gradient(160deg, var(--color-sand) 0%, var(--color-cream) 60%)">
        <div class="mx-auto max-w-4xl text-center">
            <p class="reveal section-eyebrow">Café</p>
            <h1 class="reveal mt-4 text-5xl sm:text-6xl" style="color: var(--color-mocha)">{{ $get('cafe_hero_heading') }}</h1>
            <p class="reveal mx-auto mt-6 max-w-xl text-lg opacity-80">
                {{ $get('cafe_hero_copy') }}
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-5 py-20 sm:px-8">
        <div class="grid gap-6 sm:grid-cols-3">
            <x-site.editorial-illustration type="drinks" :path="$get('cafe_tile_1_image')" :label="$get('cafe_tile_1_label')" class="reveal aspect-square rounded-sm" />
            <x-site.editorial-illustration type="food" :path="$get('cafe_tile_2_image')" :label="$get('cafe_tile_2_label')" class="reveal aspect-square rounded-sm" />
            <x-site.editorial-illustration type="space" :path="$get('cafe_tile_3_image')" :label="$get('cafe_tile_3_label')" class="reveal aspect-square rounded-sm" />
        </div>
    </section>

    <section class="px-5 py-24 text-center sm:px-8" style="background-color: var(--color-sand)">
        <x-site.section-heading align="center">{{ $get('cafe_cta_heading') }}</x-site.section-heading>
        <a href="{{ route('about') }}" class="reveal btn-secondary mt-8 inline-flex">More About the Studio</a>
    </section>

</x-layouts.site>
