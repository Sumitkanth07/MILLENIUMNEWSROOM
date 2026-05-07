@extends('frontend.layout')

@section('content')
<article class="article article-layout">
    <div class="sticky-share">
        <button class="btn small">Share</button>
        <button class="btn small">X</button>
        <button class="btn small">In</button>
    </div>
    <div>
        <nav class="breadcrumb"><a href="{{ route('home') }}">Home</a> / @if($blog->category)<a href="{{ route('category.show', $blog->category) }}">{{ $blog->category->name }}</a> / @endif <span>{{ $blog->title }}</span></nav>
        <p class="eyebrow">{{ $blog->category?->name ?? 'News' }}</p>
        <h1>{{ $blog->title }}</h1>
        <p class="muted">By {{ $blog->author?->name ?? 'MILLENIUMNEWSROOM Desk' }} · {{ optional($blog->published_at)->format('M d, Y h:i A') }}</p>
        @if($blog->author)
            <div class="author-bio author-card">
                @if($blog->author->image)<img src="{{ asset('storage/'.$blog->author->image) }}" alt="{{ $blog->author->name }}" loading="lazy">@endif
                <div><strong>{{ $blog->author->name }}</strong><p>{{ $blog->author->bio }}</p></div>
            </div>
        @endif
        @if($blog->featured_image || $blog->image)
            <figure>
                <img class="article-image" src="{{ asset('storage/'.($blog->featured_image ?: $blog->image)) }}" alt="{{ $blog->featured_image_alt ?: $blog->title }}" title="{{ $blog->featured_image_title ?: $blog->title }}" loading="eager">
                @if($blog->featured_image_caption)<figcaption>{{ $blog->featured_image_caption }}</figcaption>@endif
            </figure>
        @endif
        <p class="muted">{{ number_format($blog->views_count) }} views · {{ $blog->reading_time }} min read</p>
        <div class="share-row"><button class="btn small">Share</button><button class="btn small">X</button><button class="btn small">LinkedIn</button></div>
        <aside class="toc"><strong>Table of contents</strong><a href="#story">Story</a><a href="#related">Related stories</a><a href="#comments">Comments</a></aside>
        <div class="ad-slot">Advertisement</div>
        <div id="story" class="content">{!! $blog->content !!}</div>
        @if($blog->gallery_images)
            <section class="article-gallery">
                <div class="section-head"><div><p class="eyebrow">Gallery</p><h2>Photo Gallery</h2></div></div>
                <div class="gallery-grid">
                    @foreach($blog->gallery_images as $image)
                        <figure><img src="{{ asset('storage/'.$image) }}" alt="{{ $blog->title }} gallery image {{ $loop->iteration }}" loading="lazy"><figcaption>{{ basename($image) }}</figcaption></figure>
                    @endforeach
                </div>
            </section>
        @endif
        <div class="ad-slot">Advertisement</div>
        <div class="tags">@foreach($blog->tags as $tag)<span>{{ $tag->name }}</span>@endforeach</div>
        <section id="related"><h2>Related Stories</h2><div class="card-grid">@foreach($relatedPosts as $post)<article class="card"><h3><a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a></h3><p>{{ $post->excerpt }}</p></article>@endforeach</div></section>
        <section id="comments" class="comments-ui premium-comments">
            <h2>Join the conversation</h2>
            <div class="comment-form-grid"><input placeholder="Name"><input placeholder="Email"><textarea rows="5" placeholder="Share a thoughtful comment"></textarea></div>
            <button class="btn primary">Post comment</button>
        </section>
    </div>
    <aside class="sidebar"><h2>Trending</h2>@foreach($trendingPosts as $post)<a class="trend" href="{{ route('blog.show', $post) }}"><strong>{{ $loop->iteration }}</strong><span>{{ $post->title }}</span></a>@endforeach</aside>
</article>
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'NewsArticle',
    'headline' => $blog->title,
    'datePublished' => optional($blog->published_at)->toAtomString(),
    'dateModified' => optional($blog->updated_at)->toAtomString(),
    'author' => ['@type' => 'Person', 'name' => $blog->author?->name ?? 'MILLENIUMNEWSROOM Desk'],
    'publisher' => ['@type' => 'Organization', 'name' => 'MILLENIUMNEWSROOM'],
    'image' => ($blog->featured_image || $blog->image) ? [asset('storage/'.($blog->featured_image ?: $blog->image))] : [],
], JSON_UNESCAPED_SLASHES) !!}
</script>
@endsection
