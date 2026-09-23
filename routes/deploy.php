<?php

use App\Http\Middleware\AuthorizeDeployRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Deploy Helper Routes
|--------------------------------------------------------------------------
|
| Browser-triggered artisan commands for hosts (e.g. shared cPanel) with
| no shell/SSH access. Every route requires a `?token=` query string
| matching config('deploy.token') (see .env's DEPLOY_TOKEN) and is rate
| limited. Visit /deploy/{action}?token=... after each deploy.
|
*/

/**
 * Run an artisan command, log the attempt, and return its output as JSON
 * instead of letting exceptions bubble up as a raw error page.
 */
$runDeployCommand = function (Request $request, string $command, array $parameters = []) {
    Log::info('Deploy command triggered', [
        'command' => $command,
        'ip' => $request->ip(),
    ]);

    try {
        $exitCode = Artisan::call($command, $parameters);

        return response()->json([
            'ok' => $exitCode === 0,
            'command' => $command,
            'output' => trim(Artisan::output()),
        ], $exitCode === 0 ? 200 : 500);
    } catch (Throwable $exception) {
        report($exception);

        return response()->json([
            'ok' => false,
            'command' => $command,
            'error' => $exception->getMessage(),
        ], 500);
    }
};

Route::middleware(['throttle:6,1', AuthorizeDeployRequest::class])
    ->prefix('deploy')
    ->name('deploy.')
    ->group(function () use ($runDeployCommand) {
        Route::get('storage-link', fn (Request $request) => $runDeployCommand($request, 'storage:link'))
            ->name('storage-link');

        Route::get('optimize-clear', fn (Request $request) => $runDeployCommand($request, 'optimize:clear'))
            ->name('optimize-clear');

        Route::get('migrate', fn (Request $request) => $runDeployCommand($request, 'migrate', ['--force' => true]))
            ->name('migrate');
    });
