<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\ServiceCategory;
use Illuminate\Contracts\View\View;

class WellnessController extends Controller
{
    public function __invoke(): View
    {
        return view('site.wellness', [
            'categories' => ServiceCategory::query()
                ->where('is_active', true)
                ->with(['treatments' => fn ($q) => $q->active()->orderBy('sort_order')])
                ->orderBy('sort_order')
                ->get(),
            'faqs' => Faq::query()->active()->orderBy('sort_order')->get(),
        ]);
    }
}
