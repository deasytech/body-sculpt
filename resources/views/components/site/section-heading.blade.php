@props(['eyebrow' => null, 'align' => 'left'])

<div class="reveal {{ $align === 'center' ? 'text-center mx-auto' : '' }} max-w-2xl">
    @if ($eyebrow)
        <p class="section-eyebrow mb-3">{{ $eyebrow }}</p>
    @endif
    <h2 class="text-4xl sm:text-5xl" style="color: var(--color-mocha)">
        {{ $slot }}
    </h2>
</div>
