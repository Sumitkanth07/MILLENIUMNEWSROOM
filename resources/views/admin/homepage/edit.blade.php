@extends('admin.layout')

@section('content')
<div class="admin-title"><div><span class="kicker">Homepage Builder</span><h2>Edit {{ ucfirst(str_replace('_', ' ', $section->key)) }}</h2></div></div>
<form class="panel form" method="POST" action="{{ route('admin.homepage.update', $section) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <label>Title <input name="title" value="{{ old('title', $section->title) }}"></label>
    <label>Subtitle <input name="subtitle" value="{{ old('subtitle', $section->subtitle) }}"></label>
    <label>Content <textarea name="content" rows="6">{{ old('content', $section->content) }}</textarea></label>
    <label>Button text <input name="button_text" value="{{ old('button_text', $section->button_text) }}"></label>
    <label>Button URL <input name="button_url" value="{{ old('button_url', $section->button_url) }}"></label>
    <label>Sort order <input name="sort_order" type="number" value="{{ old('sort_order', $section->sort_order) }}"></label>
    @if($section->image)
        <div class="preview-box">
            <span>Current image</span>
            <img src="{{ asset('storage/'.$section->image) }}" alt="{{ $section->title }}">
            <small>Saved as {{ $section->image }}</small>
        </div>
    @endif
    <label>Image <input name="image" type="file" accept="image/*"></label>
    <label class="check"><input name="is_active" type="checkbox" value="1" @checked($section->is_active)> Active</label>
    <button class="btn primary">Save</button>
</form>
@endsection
