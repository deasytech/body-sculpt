@props(['dark' => false])

<a href="{{ route('home') }}" class="inline-flex flex-col leading-none {{ $dark ? 'text-cream' : 'text-mocha' }}" style="color: {{ $dark ? 'var(--color-cream)' : 'var(--color-mocha)' }}">
    <span class="font-display text-2xl tracking-[0.08em]">BODY SCULPT</span>
    <span class="text-[0.6rem] font-sans font-semibold tracking-[0.45em] uppercase mt-0.5" style="color: var(--color-sage-deep)">Wellness</span>
</a>
