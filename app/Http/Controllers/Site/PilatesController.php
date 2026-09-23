<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\PilatesClass;
use Illuminate\Contracts\View\View;

class PilatesController extends Controller
{
    public function __invoke(): View
    {
        return view('site.pilates', [
            'classes' => PilatesClass::query()->active()->with(['instructor', 'schedules' => fn ($q) => $q->active()->orderBy('day_of_week')])->orderBy('sort_order')->get(),
        ]);
    }
}
