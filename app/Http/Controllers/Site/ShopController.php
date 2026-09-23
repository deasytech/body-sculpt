<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query()->active()->with('category')->orderBy('sort_order');

        if ($category = $request->string('category')->value()) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $category));
        }

        return view('site.shop.index', [
            'products' => $query->get(),
            'categories' => ProductCategory::query()->orderBy('sort_order')->get(),
            'activeCategory' => $category,
        ]);
    }

    public function show(Product $product): View
    {
        return view('site.shop.show', [
            'product' => $product->load('category'),
            'related' => Product::query()->active()
                ->where('product_category_id', $product->product_category_id)
                ->where('id', '!=', $product->id)
                ->take(3)
                ->get(),
        ]);
    }
}
