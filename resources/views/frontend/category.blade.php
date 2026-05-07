@extends('frontend.layout')
@section('content')
<section class="page-hero"><p class="eyebrow">Category</p><h1>{{ $category->name }}</h1><p>{{ $category->meta_description }}</p></section>
<section class="news-shell content-grid">
    <div class="article-list">@foreach($posts as $post)<article class="list-card"><div><span>{{ optional($post->published_at)->format('M d, Y') }}</span><h3><a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a></h3><p>{{ $post->excerpt }}</p></div></article>@endforeach {{ $posts->links() }}</div>
    <aside class="sidebar"><h2>Trending</h2>@foreach($trendingPosts as $post)<a class="trend" href="{{ route('blog.show', $post) }}"><strong>{{ $loop->iteration }}</strong><span>{{ $post->title }}</span></a>@endforeach</aside>
</section>
@endsection
