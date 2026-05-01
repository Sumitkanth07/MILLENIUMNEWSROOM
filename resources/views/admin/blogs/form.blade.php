@extends('admin.layout')

@section('content')
<h2>{{ $blog->exists ? 'Edit Blog' : 'Create Blog' }}</h2>
<form class="panel form" method="POST" action="{{ $blog->exists ? route('admin.blogs.update', $blog) : route('admin.blogs.store') }}" enctype="multipart/form-data">
    @csrf @if($blog->exists) @method('PUT') @endif
    <label>Title <input name="title" value="{{ old('title', $blog->title) }}" required></label>
    <label>Excerpt <textarea name="excerpt" rows="3">{{ old('excerpt', $blog->excerpt) }}</textarea></label>
    <label>Content <textarea id="content" name="content" rows="14">{{ old('content', $blog->content) }}</textarea></label>
    <label>Featured image <input name="image" type="file" accept="image/*"></label>
    <label>SEO title <input name="meta_title" value="{{ old('meta_title', $blog->meta_title) }}"></label>
    <label>SEO description <textarea name="meta_description" rows="3">{{ old('meta_description', $blog->meta_description) }}</textarea></label>
    <label class="check"><input name="is_published" type="checkbox" value="1" @checked(old('is_published', $blog->is_published))> Published</label>
    <button class="btn primary">Save Blog</button>
</form>
@include('admin.partials.tinymce')
@endsection
