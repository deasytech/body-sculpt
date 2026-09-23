<div>
    @if ($sent)
        <div class="rounded-sm border p-6 text-center" style="border-color: var(--color-sand-deep); background-color: var(--color-cream)">
            <p class="font-display text-xl" style="color: var(--color-mocha)">Thank you.</p>
            <p class="mt-2 text-sm" style="color: var(--color-charcoal)">We've received your message and will be in touch shortly.</p>
        </div>
    @else
        @if ($rateLimitMessage)
            <p class="mb-4 rounded-sm bg-red-50 px-4 py-3 text-sm text-red-700">{{ $rateLimitMessage }}</p>
        @endif
        <form wire:submit="send" class="space-y-5">
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="contact-name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide" style="color: var(--color-mocha)">Name</label>
                    <input id="contact-name" type="text" wire:model="name" class="w-full rounded-sm border px-3 py-2.5 text-sm focus:outline-none focus:ring-2" style="border-color: var(--color-sand-deep); --tw-ring-color: var(--color-sage)">
                    @error('name') <p class="mt-1 text-xs text-red-700">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="contact-email" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide" style="color: var(--color-mocha)">Email</label>
                    <input id="contact-email" type="email" wire:model="email" class="w-full rounded-sm border px-3 py-2.5 text-sm focus:outline-none focus:ring-2" style="border-color: var(--color-sand-deep); --tw-ring-color: var(--color-sage)">
                    @error('email') <p class="mt-1 text-xs text-red-700">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="contact-phone" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide" style="color: var(--color-mocha)">Phone (optional)</label>
                    <input id="contact-phone" type="tel" wire:model="phone" class="w-full rounded-sm border px-3 py-2.5 text-sm focus:outline-none focus:ring-2" style="border-color: var(--color-sand-deep); --tw-ring-color: var(--color-sage)">
                </div>
                <div>
                    <label for="contact-subject" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide" style="color: var(--color-mocha)">Subject (optional)</label>
                    <input id="contact-subject" type="text" wire:model="subject" class="w-full rounded-sm border px-3 py-2.5 text-sm focus:outline-none focus:ring-2" style="border-color: var(--color-sand-deep); --tw-ring-color: var(--color-sage)">
                </div>
            </div>

            <div>
                <label for="contact-message" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide" style="color: var(--color-mocha)">Message</label>
                <textarea id="contact-message" rows="5" wire:model="message" class="w-full rounded-sm border px-3 py-2.5 text-sm focus:outline-none focus:ring-2" style="border-color: var(--color-sand-deep); --tw-ring-color: var(--color-sage)"></textarea>
                @error('message') <p class="mt-1 text-xs text-red-700">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="send">
                <span wire:loading.remove wire:target="send">Send Message</span>
                <span wire:loading wire:target="send">Sending…</span>
            </button>
        </form>
    @endif
</div>
