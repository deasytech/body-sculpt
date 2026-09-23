<x-layouts.site title="Membership" description="Make wellness a ritual with Body Sculpt Wellness memberships — Pilates, recovery and treatment benefits, every month.">

    <section class="px-5 py-24 text-center sm:px-8" style="background: linear-gradient(160deg, var(--color-sand) 0%, var(--color-cream) 60%)">
        <p class="reveal section-eyebrow">Membership</p>
        <h1 class="reveal mx-auto mt-4 max-w-2xl text-5xl sm:text-6xl" style="color: var(--color-mocha)">Make wellness a ritual.</h1>
    </section>

    <section class="mx-auto max-w-7xl px-5 py-20 sm:px-8">
        <div class="grid gap-8 lg:grid-cols-4">
            @foreach ($plans as $index => $plan)
                <x-site.membership-card :plan="$plan" :featured="$index === 1" />
            @endforeach
        </div>
    </section>

    <section class="px-5 py-20 sm:px-8" style="background-color: var(--color-sand)">
        <div class="mx-auto max-w-3xl text-center">
            <x-site.section-heading align="center">Not sure which plan fits?</x-site.section-heading>
            <p class="reveal mt-6 opacity-80">Our team can help you choose the right rhythm for your goals — book a session and we'll walk you through it in person.</p>
            <a href="{{ route('contact') }}" class="reveal btn-secondary mt-8 inline-flex">Talk to Us</a>
        </div>
    </section>

</x-layouts.site>
