@props(['type', 'path' => null, 'label' => null, 'class' => 'aspect-square'])

@if ($path)
    <img src="{{ \Illuminate\Support\Facades\Storage::url($path) }}" alt="{{ $label }}" loading="lazy" {{ $attributes->merge(['class' => $class.' w-full object-cover']) }}>
@else
<div
    {{ $attributes->merge(['class' => $class.' relative flex items-end overflow-hidden p-6']) }}
    style="background: linear-gradient(155deg, var(--color-sand) 0%, var(--color-sand-deep) 55%, var(--color-sage-deep) 140%);"
    role="img"
    aria-label="{{ $label }}"
>
    <svg viewBox="0 0 200 200" class="pointer-events-none absolute inset-0 h-full w-full opacity-80" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="var(--color-mocha)" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
        @switch($type)
            @case('drinks')
                {{-- Smoothie glass with straw and a citrus slice --}}
                <path d="M78 62 h44 l-7 92 a5 5 0 0 1-5 5 h-20 a5 5 0 0 1-5-5 Z" />
                <path d="M78 62 h44" />
                <path d="M84 84 h32" opacity="0.6" />
                <path d="M84 100 h32" opacity="0.6" />
                <line x1="112" y1="50" x2="128" y2="18" />
                <circle cx="150" cy="46" r="16" />
                <path d="M138 46 h24 M150 34 v24 M141 37 l18 18 M159 37 l-18 18" opacity="0.6" />
                <circle cx="46" cy="140" r="3" fill="var(--color-mocha)" stroke="none" opacity="0.5" />
                <circle cx="58" cy="120" r="2" fill="var(--color-mocha)" stroke="none" opacity="0.5" />
            @break

            @case('food')
                {{-- Bowl with a few simple ingredient marks --}}
                <path d="M40 108 a60 40 0 0 0 120 0 Z" />
                <path d="M34 108 h132" />
                <path d="M66 108 a34 20 0 0 0 68 0" opacity="0.6" />
                <circle cx="80" cy="90" r="7" />
                <circle cx="104" cy="82" r="5" />
                <circle cx="122" cy="92" r="6" />
                <path d="M70 60 q6 -14 0 -24" opacity="0.7" />
                <path d="M96 54 q6 -16 0 -26" opacity="0.7" />
                <path d="M122 60 q-6 -14 0 -24" opacity="0.7" />
            @break

            @case('space')
                {{-- Café window with a plant and a table --}}
                <rect x="36" y="34" width="128" height="90" rx="4" />
                <line x1="100" y1="34" x2="100" y2="124" opacity="0.6" />
                <line x1="36" y1="79" x2="164" y2="79" opacity="0.6" />
                <path d="M60 150 h80" />
                <path d="M70 150 v30 M130 150 v30" />
                <path d="M150 150 q-10 -30 14 -46 q-30 4 -26 34 q2 8 12 12 Z" opacity="0.8" />
            @break
        @endswitch
    </svg>

    @if ($label)
        <span class="relative text-xs font-semibold uppercase tracking-[0.2em]" style="color: var(--color-mocha)">{{ $label }}</span>
    @endif
</div>
@endif
