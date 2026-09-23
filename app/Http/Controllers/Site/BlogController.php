<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Contracts\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        return view('site.blog.index', [
            'posts' => BlogPost::query()->published()->with('author')->latest('published_at')->paginate(9),
        ]);
    }

    public function show(BlogPost $post): View
    {
        abort_unless($post->is_published, 404);

        return view('site.blog.show', [
            'post' => $post->load('author'),
            'recent' => BlogPost::query()->published()->where('id', '!=', $post->id)->latest('published_at')->take(3)->get(),
        ]);
    }
}
