<div>
    @if ($subscribed)
        <p class="text-sm" style="color: var(--color-sage)">Thank you — you're on the list.</p>
    @else
        @if ($rateLimitMessage)
            <p class="mb-2 text-xs text-red-300">{{ $rateLimitMessage }}</p>
        @endif
        <form wire:submit="subscribe" class="flex gap-2">
            <label for="newsletter-email" class="sr-only">Email address</label>
            <input
                type="email"
                id="newsletter-email"
                wire:model="email"
                placeholder="Your email"
                class="w-full rounded-sm border-0 bg-white/10 px-3 py-2 text-sm text-cream placeholder-white/50 focus:outline-none focus:ring-2"
                style="--tw-ring-color: var(--color-sage)"
            >
            <button type="submit" class="shrink-0 rounded-sm px-4 py-2 text-xs font-semibold uppercase tracking-wide" style="background-color: var(--color-sage-deep); color: var(--color-mocha-deep)">
                Join
            </button>
        </form>
        @error('email')
            <p class="mt-2 text-xs text-red-300">{{ $message }}</p>
        @enderror
    @endif
</div>
