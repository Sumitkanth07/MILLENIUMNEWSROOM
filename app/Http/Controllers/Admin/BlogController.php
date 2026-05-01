<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        return view('admin.blogs.index', ['blogs' => Blog::latest()->paginate(12)]);
    }

    public function create()
    {
        return view('admin.blogs.form', ['blog' => new Blog()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['user_id'] = $request->user()->id;
        $data['slug'] = Blog::uniqueSlug($data['title']);
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? now() : null;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
        }

        Blog::create($data);

        return redirect()->route('admin.blogs.index')->with('status', 'Blog created.');
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.form', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $this->validated($request);
        $data['slug'] = Blog::uniqueSlug($data['title'], $blog->id);
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? ($blog->published_at ?: now()) : null;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('status', 'Blog updated.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return back()->with('status', 'Blog deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
        ]);
    }
}
