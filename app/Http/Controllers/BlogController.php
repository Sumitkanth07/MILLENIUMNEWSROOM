<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        return view('blog.index', [
            'blogs' => Blog::where('is_published', true)->latest('published_at')->paginate(9),
            'metaTitle' => 'Blog | Navurja',
            'metaDescription' => 'Renewable energy, clean energy, sustainable energy and solar solutions insights from Navurja.',
        ]);
    }

    public function show(Blog $blog)
    {
        abort_unless($blog->is_published, 404);

        return view('blog.show', [
            'blog' => $blog,
            'metaTitle' => $blog->meta_title ?: $blog->title.' | Navurja',
            'metaDescription' => $blog->meta_description ?: $blog->excerpt,
        ]);
    }
}
