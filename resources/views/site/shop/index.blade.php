<x-layouts.site title="Shop" description="Body Sculpt Wellness studio essentials — grip socks, accessories and more.">

    <section class="px-5 py-24 text-center sm:px-8" style="background: linear-gradient(160deg, var(--color-sand) 0%, var(--color-cream) 60%)">
        <p class="reveal section-eyebrow">Shop Body Sculpt</p>
        <h1 class="reveal mx-auto mt-4 max-w-2xl text-5xl sm:text-6xl" style="color: var(--color-mocha)">Studio essentials.</h1>
    </section>

    <section class="mx-auto max-w-7xl px-5 py-16 sm:px-8">
        <div class="reveal flex flex-wrap gap-3">
            <a href="{{ route('shop') }}" class="rounded-full border px-4 py-1.5 text-sm" style="border-color: var(--color-sand-deep); {{ ! $activeCategory ? 'background-color: var(--color-mocha); color: var(--color-cream);' : 'color: var(--color-mocha);' }}">All</a>
            @foreach ($categories as $category)
                <a href="{{ route('shop', ['category' => $category->slug]) }}" class="rounded-full border px-4 py-1.5 text-sm" style="border-color: var(--color-sand-deep); {{ $activeCategory === $category->slug ? 'background-color: var(--color-mocha); color: var(--color-cream);' : 'color: var(--color-mocha);' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <div class="mt-10 grid gap-x-6 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($products as $product)
                <a href="{{ route('shop.show', $product) }}" class="reveal group block">
                    <div class="overflow-hidden rounded-sm">
                        <x-site.image-placeholder :path="$product->image_path" :alt="$product->name" :label="$product->category?->name" class="aspect-square transition-transform duration-700 group-hover:scale-105" />
                    </div>
                    <h3 class="mt-4 font-display text-lg" style="color: var(--color-mocha)">{{ $product->name }}</h3>
                    <p class="mt-1 text-sm" style="color: var(--color-sage-deep)">₦{{ number_format($product->priceInNaira()) }}</p>
                </a>
            @empty
                <p class="opacity-70">No products found in this category yet.</p>
            @endforelse
        </div>
    </section>

</x-layouts.site>
