<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <div class="bg-muted relative hidden h-full flex-col p-10 text-white lg:flex dark:border-e dark:border-neutral-800">
                <div class="absolute inset-0 bg-neutral-900"></div>
                <img
                    src="{{ Illuminate\Support\Facades\Storage::url('pilates-classes/reformer-beginner.jpg') }}"
                    alt=""
                    class="absolute inset-0 h-full w-full object-cover opacity-60"
                >
                <div class="absolute inset-0 bg-linear-to-t from-neutral-950 via-neutral-950/60 to-neutral-950/20"></div>

                <div class="relative z-20">
                    <x-site.logo dark />
                </div>

                <div class="relative z-20 mt-auto">
                    <blockquote class="space-y-2">
                        <flux:heading size="lg">&ldquo;{{ \App\Models\Setting::get('tagline', 'Relax your body, mind & spirit.') }}&rdquo;</flux:heading>
                        <footer><flux:heading>Body Sculpt Wellness &middot; Lekki Phase 1, Lagos</flux:heading></footer>
                    </blockquote>
                </div>
            </div>
            <div class="w-full lg:p-8">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                    <div class="z-20 flex flex-col items-center gap-2 lg:hidden">
                        <x-site.logo />
                    </div>
                    {{ $slot }}
                </div>
            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
