<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        return view('blog.index', [
            'blogs' => Blog::with(['category', 'author'])->where('is_published', true)->latest('published_at')->paginate(9),
            'metaTitle' => 'Latest News | MILLENIUMNEWSROOM',
            'metaDescription' => 'Latest news, analysis and opinion from MILLENIUMNEWSROOM.',
        ]);
    }

    public function show(Blog $blog)
    {
        abort_unless($blog->is_published, 404);
        $blog->increment('views_count');

        return view('blog.show', [
            'blog' => $blog->load(['category', 'author', 'tags']),
            'relatedPosts' => Blog::where('is_published', true)->whereKeyNot($blog->id)->latest('published_at')->take(4)->get(),
            'trendingPosts' => Blog::where('is_published', true)->orderByDesc('views_count')->take(5)->get(),
            'metaTitle' => $blog->meta_title ?: $blog->title.' | MILLENIUMNEWSROOM',
            'metaDescription' => $blog->meta_description ?: $blog->excerpt,
            'robotsMeta' => $blog->robots_meta ?: 'index,follow',
            'ogImage' => ($blog->featured_image || $blog->image) ? asset('storage/'.($blog->featured_image ?: $blog->image)) : null,
        ]);
    }
}
