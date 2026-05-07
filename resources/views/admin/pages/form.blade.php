@extends('admin.layout')
@section('content')
<h2>{{ $page->exists ? 'Edit Page' : 'Create Page' }}</h2>
<form class="panel form" method="POST" action="{{ $page->exists ? route('admin.pages.update', $page) : route('admin.pages.store') }}" enctype="multipart/form-data">
    @csrf @if($page->exists) @method('PUT') @endif
    <label>Title <input name="title" value="{{ old('title', $page->title) }}" required></label>
    <label>Slug <input name="slug" value="{{ old('slug', $page->slug) }}"></label>
    <label>Banner image <input name="banner_image" type="file" accept="image/*"></label>
    <label>Content <textarea id="content" name="content" rows="14">{{ old('content', $page->content) }}</textarea></label>
    <label>SEO title <input name="meta_title" value="{{ old('meta_title', $page->meta_title) }}"></label>
    <label>SEO description <textarea name="meta_description" rows="3">{{ old('meta_description', $page->meta_description) }}</textarea></label>
    <label class="check"><input name="is_published" type="checkbox" value="1" @checked(old('is_published', $page->is_published ?? true))> Published</label>
    <button class="btn primary">Save Page</button>
</form>
@include('admin.partials.tinymce')
@endsection
