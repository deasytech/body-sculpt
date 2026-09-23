<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeDeployRequest
{
    public function handle(Request $request, Closure $next): Response
    {
        $configuredToken = (string) config('deploy.token');
        $providedToken = (string) $request->query('token');

        abort_unless($configuredToken !== '' && hash_equals($configuredToken, $providedToken), 403);

        return $next($request);
    }
}
