@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'type' => 'website',
])

@php
    use Illuminate\Support\Facades\Storage;

    $siteName = \App\Models\Setting::get('site_name', config('app.name'));
    $pageTitle = $title ? "{$title} — {$siteName}" : "{$siteName} — Premium Pilates, Wellness & Body Sculpting in Lekki, Lagos";
    $metaDescription = $description ?? \App\Models\Setting::get('tagline');
    $location = \App\Models\Location::query()->where('is_primary', true)->first();

    $resolveImage = function (?string $path) {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return url(Storage::url($path));
    };

    $ogImage = $resolveImage($image) ?? $resolveImage(\App\Models\Setting::get('home_hero_image'));
@endphp

<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $metaDescription }}">
<link rel="canonical" href="{{ url()->current() }}">

<meta property="og:type" content="{{ $type }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:locale" content="en_NG">
@if ($ogImage)
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:alt" content="{{ $pageTitle }}">
@endif

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
@if ($ogImage)
    <meta name="twitter:image" content="{{ $ogImage }}">
@endif

@if ($location)
    @php
        $openingHours = $location->openingHours()->where('is_closed', false)->orderBy('day_of_week')->get();
        $dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $instagramUrl = \App\Models\Setting::get('instagram_url');

        $businessSchema = array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'HealthAndBeautyBusiness',
            'name' => $siteName,
            'description' => \App\Models\Setting::get('tagline'),
            'url' => url('/'),
            'image' => $ogImage,
            'priceRange' => '₦₦',
            'telephone' => $location->phone,
            'email' => $location->email,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $location->address_line1,
                'addressLocality' => $location->city,
                'addressRegion' => $location->state,
                'addressCountry' => $location->country,
            ],
            'geo' => ($location->latitude && $location->longitude) ? [
                '@type' => 'GeoCoordinates',
                'latitude' => (float) $location->latitude,
                'longitude' => (float) $location->longitude,
            ] : null,
            'sameAs' => $instagramUrl ? [$instagramUrl] : null,
            'openingHoursSpecification' => $openingHours->isNotEmpty() ? $openingHours->map(fn ($hours) => [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => 'https://schema.org/'.$dayNames[$hours->day_of_week],
                'opens' => \Illuminate\Support\Carbon::parse($hours->opens_at)->format('H:i'),
                'closes' => \Illuminate\Support\Carbon::parse($hours->closes_at)->format('H:i'),
            ])->all() : null,
        ], fn ($value) => $value !== null);
    @endphp
    <script type="application/ld+json">
        {!! json_encode($businessSchema, JSON_UNESCAPED_SLASHES) !!}
    </script>
@endif

@stack('schema')
