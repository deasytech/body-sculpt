@php
    $postBreadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Journal', 'item' => route('blog')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $post->title, 'item' => route('blog.show', $post)],
        ],
    ];

    $postSchema = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
        'headline' => $post->title,
        'description' => $post->excerpt,
        'image' => $post->cover_image_path ? url(\Illuminate\Support\Facades\Storage::url($post->cover_image_path)) : null,
        'datePublished' => $post->published_at?->toAtomString(),
        'dateModified' => $post->updated_at?->toAtomString(),
        'author' => $post->author ? [
            '@type' => 'Person',
            'name' => $post->author->name,
        ] : null,
        'publisher' => [
            '@type' => 'Organization',
            'name' => \App\Models\Setting::get('site_name', config('app.name')),
        ],
        'mainEntityOfPage' => route('blog.show', $post),
    ]);
@endphp

@push('schema')
    <script type="application/ld+json">{!! json_encode($postBreadcrumbSchema, JSON_UNESCAPED_SLASHES) !!}</script>
    <script type="application/ld+json">{!! json_encode($postSchema, JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

<x-layouts.site :title="$post->title" :description="$post->excerpt" :image="$post->cover_image_path" type="article">

    <article class="mx-auto max-w-3xl px-5 py-20 sm:px-8">
        <p class="reveal text-sm">
            <a href="{{ route('blog') }}" class="opacity-70 hover:opacity-100" style="color: var(--color-mocha)">&larr; Journal</a>
        </p>

        <p class="reveal mt-6 text-xs uppercase tracking-wide" style="color: var(--color-sage-deep)">
            {{ $post->published_at?->format('F j, Y') }}
            @if ($post->author)
                · {{ $post->author->name }}
            @endif
        </p>
        <h1 class="reveal mt-3 text-4xl sm:text-5xl" style="color: var(--color-mocha)">{{ $post->title }}</h1>

        <div class="reveal mt-10 overflow-hidden rounded-sm">
            <x-site.image-placeholder :path="$post->cover_image_path" :alt="$post->title" class="aspect-[16/9]" />
        </div>

        <div class="reveal prose mt-10 max-w-none text-lg leading-relaxed opacity-90">
            {!! $post->body !!}
        </div>
    </article>

    @if ($recent->isNotEmpty())
        <section class="px-5 py-20 sm:px-8" style="background-color: var(--color-sand)">
            <div class="mx-auto max-w-7xl">
                <x-site.section-heading eyebrow="Keep Reading">More from the journal.</x-site.section-heading>

                <div class="mt-12 grid gap-8 sm:grid-cols-3">
                    @foreach ($recent as $item)
                        <a href="{{ route('blog.show', $item) }}" class="reveal group block">
                            <x-site.image-placeholder :path="$item->cover_image_path" :alt="$item->title" class="aspect-[4/3] rounded-sm transition-transform duration-700 group-hover:scale-105" />
                            <h3 class="mt-4 font-display text-lg" style="color: var(--color-mocha)">{{ $item->title }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</x-layouts.site>
