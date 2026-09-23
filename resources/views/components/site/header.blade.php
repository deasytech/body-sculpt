@php
    $navItems = [
        ['label' => 'About', 'route' => 'about'],
        ['label' => 'Pilates', 'route' => 'pilates'],
        ['label' => 'Wellness', 'route' => 'wellness'],
        ['label' => 'Membership', 'route' => 'membership'],
        ['label' => 'Café', 'route' => 'cafe'],
        ['label' => 'Shop', 'route' => 'shop'],
    ];
@endphp

<header
    x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 12)"
    :class="scrolled ? 'shadow-sm backdrop-blur-md' : ''"
    class="sticky top-0 z-50 transition-shadow duration-300"
    style="background-color: color-mix(in srgb, var(--color-cream) 92%, transparent)"
>
    <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 sm:px-8">
        <x-site.logo />

        <nav class="hidden items-center gap-8 lg:flex">
            @foreach ($navItems as $item)
                <a
                    href="{{ route($item['route']) }}"
                    class="text-sm font-medium tracking-wide transition-colors hover:opacity-70 {{ request()->routeIs($item['route']) ? 'font-semibold' : '' }}"
                    style="color: var(--color-mocha)"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-3">
            <a
                href="{{ route(auth()->check() ? 'dashboard' : 'login') }}"
                class="hidden items-center gap-2 rounded-sm border px-4 py-3 text-sm font-semibold tracking-wide uppercase transition-colors hover:opacity-70 sm:inline-flex"
                style="border-color: var(--color-mocha); color: var(--color-mocha)"
                wire:navigate
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                {{ auth()->check() ? 'My Account' : 'Log in' }}
            </a>

            <a href="{{ route('book') }}" class="btn-primary hidden sm:inline-flex">
                Book a Session <span aria-hidden="true">&rarr;</span>
            </a>

            <button
                @click="open = !open"
                type="button"
                class="inline-flex items-center justify-center rounded-sm p-2 lg:hidden"
                style="color: var(--color-mocha)"
                :aria-expanded="open"
                aria-label="Toggle menu"
            >
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" /></svg>
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </div>
    </div>

    <div
        x-show="open"
        x-transition
        x-cloak
        class="border-t lg:hidden"
        style="background-color: var(--color-cream); border-color: var(--color-sand-deep)"
    >
        <nav class="flex flex-col gap-1 px-5 py-4">
            @foreach ($navItems as $item)
                <a href="{{ route($item['route']) }}" class="rounded-sm px-2 py-3 text-base font-medium" style="color: var(--color-mocha)">
                    {{ $item['label'] }}
                </a>
            @endforeach
            <a href="{{ route(auth()->check() ? 'dashboard' : 'login') }}" class="rounded-sm px-2 py-3 text-base font-medium" style="color: var(--color-mocha)" wire:navigate>
                {{ auth()->check() ? 'My Account' : 'Log in' }}
            </a>
            <a href="{{ route('book') }}" class="btn-primary mt-2 justify-center">
                Book a Session &rarr;
            </a>
        </nav>
    </div>
</header>
