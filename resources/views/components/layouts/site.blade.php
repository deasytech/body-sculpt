<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <x-site.seo :title="$title ?? null" :description="$description ?? null" :image="$image ?? null" />

    <link rel="icon" href="/favicon/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="/favicon/favicon-96x96.png" type="image/png" sizes="96x96">
    <link rel="apple-touch-icon" href="/favicon/apple-touch-icon.png">
    <link rel="manifest" href="/favicon/site.webmanifest">

    @fonts
    @vite(['resources/css/site.css', 'resources/js/site.js'])
    @livewireStyles
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="site font-sans antialiased">
    <a
        href="#main-content"
        class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-60 focus:rounded-sm focus:px-4 focus:py-2 focus:text-sm focus:font-semibold"
        style="background-color: var(--color-mocha); color: var(--color-cream)"
    >
        Skip to content
    </a>

    <x-site.header />

    <main id="main-content">
        {{ $slot }}
    </main>

    <x-site.footer />

    @livewireScripts
</body>
</html>
