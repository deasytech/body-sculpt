@props(['plan', 'featured' => false])

<div
    class="reveal flex flex-col rounded-sm border p-8"
    style="{{ $featured ? 'background-color: var(--color-mocha); border-color: var(--color-mocha); color: var(--color-cream);' : 'background-color: var(--color-cream); border-color: var(--color-sand-deep); color: var(--color-charcoal);' }}"
>
    <h3 class="font-display text-2xl" style="{{ $featured ? '' : 'color: var(--color-mocha)' }}">{{ $plan->name }}</h3>
    <p class="mt-3 text-3xl font-semibold">
        ₦{{ number_format($plan->price / 100) }}
        <span class="text-sm font-normal opacity-70">/ {{ strtolower($plan->billing_interval->label()) }}</span>
    </p>

    <ul class="mt-6 flex-1 space-y-3 text-sm">
        @foreach ($plan->benefits ?? [] as $benefit)
            <li class="flex items-start gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 shrink-0" style="color: {{ $featured ? 'var(--color-sage)' : 'var(--color-sage-deep)' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                <span class="opacity-90">{{ $benefit }}</span>
            </li>
        @endforeach
    </ul>

    <a
        href="{{ route('book') }}"
        class="mt-8 inline-flex items-center justify-center rounded-sm px-6 py-3 text-sm font-semibold uppercase tracking-wide transition-colors"
        style="{{ $featured ? 'background-color: var(--color-cream); color: var(--color-mocha);' : 'background-color: var(--color-mocha); color: var(--color-cream);' }}"
    >
        Choose Plan
    </a>
</div>
