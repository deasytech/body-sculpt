<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Staff;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    public function __invoke(): View
    {
        return view('site.about', [
            'page' => Page::query()->where('slug', 'about')->first(),
            'team' => Staff::query()->active()->whereIn('type', ['instructor', 'therapist'])->orderBy('sort_order')->get(),
        ]);
    }
}
