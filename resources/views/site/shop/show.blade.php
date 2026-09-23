@php
    $productBreadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Shop', 'item' => route('shop')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $product->name, 'item' => route('shop.show', $product)],
        ],
    ];

    $productSchema = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $product->name,
        'description' => $product->description,
        'category' => $product->category?->name,
        'image' => $product->image_path ? url(\Illuminate\Support\Facades\Storage::url($product->image_path)) : null,
        'sku' => $product->sku,
        'offers' => [
            '@type' => 'Offer',
            'price' => $product->priceInNaira(),
            'priceCurrency' => 'NGN',
            'url' => route('shop.show', $product),
            'availability' => $product->inStock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
        ],
    ]);
@endphp

@push('schema')
    <script type="application/ld+json">{!! json_encode($productBreadcrumbSchema, JSON_UNESCAPED_SLASHES) !!}</script>
    <script type="application/ld+json">{!! json_encode($productSchema, JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

<x-layouts.site :title="$product->name" :description="$product->description" :image="$product->image_path" type="product">

    <section class="mx-auto max-w-6xl px-5 py-16 sm:px-8">
        <p class="reveal text-sm">
            <a href="{{ route('shop') }}" class="opacity-70 hover:opacity-100" style="color: var(--color-mocha)">&larr; Shop</a>
        </p>

        <div class="mt-8 grid gap-12 lg:grid-cols-2">
            <div class="reveal overflow-hidden rounded-sm">
                <x-site.image-placeholder :path="$product->image_path" :alt="$product->name" :label="$product->category?->name" class="aspect-square" />
            </div>

            <div>
                <p class="section-eyebrow reveal">{{ $product->category?->name }}</p>
                <h1 class="reveal mt-3 text-4xl sm:text-5xl" style="color: var(--color-mocha)">{{ $product->name }}</h1>
                <p class="reveal mt-6 text-lg opacity-80">{{ $product->description }}</p>
                <p class="reveal mt-6 font-display text-3xl" style="color: var(--color-mocha)">₦{{ number_format($product->priceInNaira()) }}</p>

                <p class="reveal mt-2 text-sm" style="color: {{ $product->inStock() ? 'var(--color-sage-deep)' : '#b45309' }}">
                    {{ $product->inStock() ? 'Available in studio' : 'Currently out of stock' }}
                </p>

                <a href="{{ route('contact', ['subject' => 'Purchase enquiry: '.$product->name]) }}" class="btn-primary reveal mt-8 inline-flex">
                    Enquire to Purchase &rarr;
                </a>
            </div>
        </div>
    </section>

    @if ($related->isNotEmpty())
        <section class="px-5 py-20 sm:px-8" style="background-color: var(--color-sand)">
            <div class="mx-auto max-w-7xl">
                <x-site.section-heading eyebrow="You May Also Like">More studio essentials.</x-site.section-heading>

                <div class="mt-12 grid gap-8 sm:grid-cols-3">
                    @foreach ($related as $item)
                        <a href="{{ route('shop.show', $item) }}" class="reveal group block">
                            <x-site.image-placeholder :path="$item->image_path" :alt="$item->name" class="aspect-square rounded-sm transition-transform duration-700 group-hover:scale-105" />
                            <h3 class="mt-4 font-display text-lg" style="color: var(--color-mocha)">{{ $item->name }}</h3>
                            <p class="mt-1 text-sm" style="color: var(--color-sage-deep)">₦{{ number_format($item->priceInNaira()) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</x-layouts.site>
