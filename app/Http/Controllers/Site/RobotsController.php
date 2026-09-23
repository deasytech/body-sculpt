<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class RobotsController extends Controller
{
    public function __invoke(): Response
    {
        $disallowed = [
            '/admin',
            '/dashboard',
            '/settings',
            '/deploy',
            '/login',
            '/register',
            '/forgot-password',
            '/reset-password',
            '/two-factor-challenge',
            '/user',
            '/passkeys',
        ];

        $lines = collect(['User-agent: *'])
            ->concat(collect($disallowed)->map(fn (string $path) => "Disallow: {$path}"))
            ->push('')
            ->push('Sitemap: '.route('sitemap'))
            ->implode("\n");

        return response($lines, 200)->header('Content-Type', 'text/plain');
    }
}
