<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;

class BlogController extends Controller
{
    public function index()
    {
        return view('blog.index', [

            'blogs' => Blog::with(['category', 'author'])
                ->where('is_published', true)
                ->latest('published_at')
                ->paginate(9),

            'metaTitle' => 'Latest News | MILLENNIUM NEWSROOM',

            'metaDescription' => 'Latest news, analysis and opinion from MILLENNIUM NEWSROOM.',

        ]);
    }

    public function redirectLegacy(Blog $blog)
    {
        return redirect()->to($blog->load('category')->publicUrl(), 301);
    }

    public function show(Category $category, Blog $blog)
    {
        abort_unless($blog->is_published, 404);
        abort_unless((int) $blog->category_id === (int) $category->id, 404);

        $blog->increment('views_count');

        return view('blog.show', [

            'blog' => $blog->load([
                'category',
                'author',
                'tags'
            ]),

            'relatedPosts' => Blog::with([
                    'category',
                    'author'
                ])
                ->where('is_published', true)
                ->whereKeyNot($blog->id)
                ->latest('published_at')
                ->take(4)
                ->get(),

            'trendingPosts' => Blog::with('category')
                ->where('is_published', true)
                ->orderByDesc('views_count')
                ->take(5)
                ->get(),

            'metaTitle' => $blog->meta_title
                ?: $blog->title.' | MILLENNIUM NEWSROOM',

            'metaDescription' => $blog->meta_description
                ?: $blog->excerpt,

            'robotsMeta' => $blog->robots_meta
                ?: 'index,follow',

            'canonicalUrl' => $blog->canonical_url
                ?: $blog->publicUrl(),

            'ogType' => 'article',

            'ogImage' => ($blog->featured_image || $blog->image)
                ? url(asset($blog->featured_image ?: $blog->image))
                : null,

        ]);
    }
}
