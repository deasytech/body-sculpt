<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use App\Models\PilatesClass;
use App\Models\ServiceCategory;
use App\Models\Testimonial;
use App\Models\Treatment;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('site.home', [
            'categories' => ServiceCategory::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'featuredClasses' => PilatesClass::query()->active()->with('instructor')->orderBy('sort_order')->take(3)->get(),
            'recoveryRituals' => Treatment::query()->active()->whereHas('category', fn ($q) => $q->where('slug', 'recovery'))->orderBy('sort_order')->take(5)->get(),
            'sculptTreatments' => Treatment::query()->active()->whereHas('category', fn ($q) => $q->where('slug', 'sculpt'))->orderBy('sort_order')->take(5)->get(),
            'facials' => Treatment::query()->active()->whereHas('category', fn ($q) => $q->where('slug', 'facials'))->orderBy('sort_order')->take(5)->get(),
            'membershipPlans' => MembershipPlan::query()->active()->orderBy('sort_order')->take(3)->get(),
            'testimonials' => Testimonial::query()->active()->featured()->orderBy('sort_order')->take(4)->get(),
        ]);
    }
}
