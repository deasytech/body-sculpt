@props(['treatment'])

<a href="{{ route('treatments.show', $treatment) }}" class="reveal group block">
    <div class="overflow-hidden rounded-sm">
        <x-site.image-placeholder
            :path="$treatment->image_path"
            :alt="$treatment->name"
            :label="$treatment->category?->name"
            class="aspect-[4/5] transition-transform duration-700 group-hover:scale-105"
        />
    </div>
    <div class="mt-4 flex items-start justify-between gap-3">
        <div>
            <h3 class="font-display text-xl" style="color: var(--color-mocha)">{{ $treatment->name }}</h3>
            <p class="mt-1 text-sm opacity-70">{{ $treatment->short_description }}</p>
        </div>
    </div>
    <div class="mt-3 flex items-center justify-between text-sm" style="color: var(--color-sage-deep)">
        <span>{{ $treatment->duration_minutes }} min</span>
        <span>₦{{ number_format($treatment->priceInNaira()) }}</span>
    </div>
</a>
