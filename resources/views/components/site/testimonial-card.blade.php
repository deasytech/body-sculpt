@props(['testimonial'])

<figure class="reveal rounded-sm p-8" style="background-color: var(--color-sand)">
    <blockquote class="font-display text-xl leading-relaxed" style="color: var(--color-mocha)">
        &ldquo;{{ $testimonial->quote }}&rdquo;
    </blockquote>
    <figcaption class="mt-6 text-sm">
        <span class="font-semibold" style="color: var(--color-mocha)">{{ $testimonial->customer_name }}</span>
        @if ($testimonial->service_name)
            <span class="opacity-70"> — {{ $testimonial->service_name }}</span>
        @endif
    </figcaption>
</figure>
