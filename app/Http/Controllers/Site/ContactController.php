<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Contracts\View\View;

class ContactController extends Controller
{
    public function __invoke(): View
    {
        return view('site.contact', [
            'location' => Location::query()->where('is_primary', true)->first(),
        ]);
    }
}
