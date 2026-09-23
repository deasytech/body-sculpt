<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class CafeController extends Controller
{
    public function __invoke(): View
    {
        return view('site.cafe');
    }
}
