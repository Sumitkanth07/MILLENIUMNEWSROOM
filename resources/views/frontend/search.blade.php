@extends('frontend.layout')
@section('content')
<section class="page-hero"><p class="eyebrow">Search</p><h1>News Search</h1></section>
<section class="news-shell">
    <form class="panel search-panel" method="GET" action="{{ route('search') }}">
        <input name="q" value="{{ $query }}" placeholder="Search stories, companies, topics">
        <select name="category"><option value="">All categories</option>@foreach($categories as $category)<option value="{{ $category->slug }}" @selected($selectedCategory === $category->slug)>{{ $category->name }}</option>@endforeach</select>
        <select name="sort"><option value="latest" @selected($sort === 'latest')>Latest</option><option value="popular" @selected($sort === 'popular')>Popular</option></select>
        <button class="btn primary">Search</button>
    </form>
    <div class="article-list">
        @forelse($posts as $post)
            @php($image = $post->featured_image ?: $post->image)
            <article class="list-card">
                @if($image)<img src="{{ asset($image) }}" alt="{{ $post->featured_image_alt ?: $post->title }}" loading="lazy" decoding="async">@endif
                <div><span>{{ $post->category?->name }}</span><h3><a href="{{ route('blog.show', ['blog' => $post->slug]) }}">{{ $post->title }}</a></h3><p>{{ $post->excerpt }}</p></div>
            </article>
        @empty
            <div class="card empty-state"><h2>No results found</h2><p>Try another keyword or category.</p></div>
        @endforelse
    </div>
    {{ $posts->links() }}
</section>
@endsection
