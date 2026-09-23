@props(['pilatesClass'])

<div class="reveal group">
    <div class="overflow-hidden rounded-sm">
        <x-site.image-placeholder
            :path="$pilatesClass->image_path"
            :alt="$pilatesClass->name"
            :label="$pilatesClass->level->label()"
            class="aspect-[4/5] transition-transform duration-700 group-hover:scale-105"
        />
    </div>
    <div class="mt-4">
        <h3 class="font-display text-xl" style="color: var(--color-mocha)">{{ $pilatesClass->name }}</h3>
        <p class="mt-1 text-sm opacity-70">{{ $pilatesClass->description }}</p>
        @if ($pilatesClass->instructor)
            <p class="mt-2 text-xs uppercase tracking-wide" style="color: var(--color-sage-deep)">With {{ $pilatesClass->instructor->name }}</p>
        @endif
    </div>
</div>
