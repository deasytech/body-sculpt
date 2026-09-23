<x-layouts.site title="Journal" description="Wellness notes, studio updates and stories from Body Sculpt Wellness.">

    <section class="px-5 py-24 text-center sm:px-8" style="background: linear-gradient(160deg, var(--color-sand) 0%, var(--color-cream) 60%)">
        <p class="reveal section-eyebrow">Journal</p>
        <h1 class="reveal mx-auto mt-4 max-w-2xl text-5xl sm:text-6xl" style="color: var(--color-mocha)">Notes on wellness.</h1>
    </section>

    <section class="mx-auto max-w-7xl px-5 py-20 sm:px-8">
        @if ($posts->isEmpty())
            <p class="opacity-70">Nothing published yet — check back soon.</p>
        @else
            <div class="grid gap-x-8 gap-y-16 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($posts as $post)
                    <a href="{{ route('blog.show', $post) }}" class="reveal group block">
                        <div class="overflow-hidden rounded-sm">
                            <x-site.image-placeholder :path="$post->cover_image_path" :alt="$post->title" class="aspect-[4/3] transition-transform duration-700 group-hover:scale-105" />
                        </div>
                        <p class="mt-4 text-xs uppercase tracking-wide" style="color: var(--color-sage-deep)">
                            {{ $post->published_at?->format('F j, Y') }}
                        </p>
                        <h2 class="mt-2 font-display text-xl" style="color: var(--color-mocha)">{{ $post->title }}</h2>
                        <p class="mt-2 text-sm opacity-70">{{ $post->excerpt }}</p>
                    </a>
                @endforeach
            </div>

            <div class="mt-16">
                {{ $posts->links() }}
            </div>
        @endif
    </section>

</x-layouts.site>
