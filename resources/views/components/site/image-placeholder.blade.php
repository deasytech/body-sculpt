@props(['path' => null, 'alt' => '', 'label' => null, 'class' => 'aspect-[4/5]', 'priority' => false])

@if ($path)
    <img
        src="{{ \Illuminate\Support\Facades\Storage::url($path) }}"
        alt="{{ $alt }}"
        @if ($priority)
            loading="eager" fetchpriority="high"
        @else
            loading="lazy"
        @endif
        {{ $attributes->merge(['class' => $class.' w-full object-cover']) }}
    >
@else
    <div
        {{ $attributes->merge(['class' => $class.' w-full flex items-end justify-start p-6']) }}
        style="background: linear-gradient(155deg, var(--color-sand) 0%, var(--color-sand-deep) 55%, var(--color-sage-deep) 140%);"
        role="img"
        aria-label="{{ $alt }}"
    >
        @if ($label)
            <span class="text-xs font-semibold uppercase tracking-[0.2em]" style="color: var(--color-mocha)">{{ $label }}</span>
        @endif
    </div>
@endif
