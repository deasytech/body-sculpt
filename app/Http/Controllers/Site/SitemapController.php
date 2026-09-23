<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Product;
use App\Models\Treatment;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $xml = Cache::remember('sitemap.xml', now()->addHour(), function () {
            $urls = collect([
                ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'weekly'],
                ['loc' => route('about'), 'priority' => '0.8', 'changefreq' => 'monthly'],
                ['loc' => route('pilates'), 'priority' => '0.8', 'changefreq' => 'weekly'],
                ['loc' => route('wellness'), 'priority' => '0.8', 'changefreq' => 'weekly'],
                ['loc' => route('membership'), 'priority' => '0.8', 'changefreq' => 'monthly'],
                ['loc' => route('cafe'), 'priority' => '0.6', 'changefreq' => 'monthly'],
                ['loc' => route('shop'), 'priority' => '0.7', 'changefreq' => 'weekly'],
                ['loc' => route('contact'), 'priority' => '0.5', 'changefreq' => 'yearly'],
                ['loc' => route('blog'), 'priority' => '0.6', 'changefreq' => 'weekly'],
            ]);

            $urls = $urls
                ->concat(Treatment::query()->active()->get()->map(fn (Treatment $t) => [
                    'loc' => route('treatments.show', $t),
                    'priority' => '0.7',
                    'changefreq' => 'monthly',
                    'lastmod' => $t->updated_at?->toAtomString(),
                ]))
                ->concat(Product::query()->active()->get()->map(fn (Product $p) => [
                    'loc' => route('shop.show', $p),
                    'priority' => '0.6',
                    'changefreq' => 'weekly',
                    'lastmod' => $p->updated_at?->toAtomString(),
                ]))
                ->concat(BlogPost::query()->published()->get()->map(fn (BlogPost $b) => [
                    'loc' => route('blog.show', $b),
                    'priority' => '0.5',
                    'changefreq' => 'monthly',
                    'lastmod' => $b->updated_at?->toAtomString(),
                ]));

            $xml = view('site.sitemap', ['urls' => $urls])->render();

            return $xml;
        });

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
