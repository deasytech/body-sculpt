<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use Illuminate\Contracts\View\View;

class MembershipController extends Controller
{
    public function __invoke(): View
    {
        return view('site.membership', [
            'plans' => MembershipPlan::query()->active()->orderBy('sort_order')->get(),
        ]);
    }
}
