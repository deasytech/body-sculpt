<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Treatment;
use Illuminate\Contracts\View\View;

class TreatmentController extends Controller
{
    public function __invoke(Treatment $treatment): View
    {
        $treatment->load('category');

        $related = Treatment::query()
            ->active()
            ->where('service_category_id', $treatment->service_category_id)
            ->where('id', '!=', $treatment->id)
            ->take(3)
            ->get();

        return view('site.treatment-show', [
            'treatment' => $treatment,
            'related' => $related,
        ]);
    }
}
