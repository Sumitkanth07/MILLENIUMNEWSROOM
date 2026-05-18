@extends('frontend.layout')

@section('content')
<section class="portal-home">
    <div class="hero-slider" data-slider>
        @foreach(($featuredPosts->isNotEmpty() ? $featuredPosts : $topHeadlines)->take(5) as $post)
            <article class="hero-slide @if($loop->first) active @endif">
                @if($post->featured_image || $post->image)<img src="{{ asset('storage/'.($post->featured_image ?: $post->image)) }}" alt="{{ $post->featured_image_alt ?: $post->title }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}" decoding="async">@endif
                <div class="hero-slide-copy">
                    <span class="badge gold">{{ $post->category?->name ?? 'Featured' }}</span>
                    <h1><a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a></h1>
                    <p>{{ $post->excerpt }}</p>
                    <small>{{ optional($post->published_at)->format('M d, Y') }} · {{ number_format($post->views_count) }} views</small>
                </div>
            </article>
        @endforeach
        <button class="slider-btn prev" type="button" data-slide-prev aria-label="Previous story">&lsaquo;</button>
        <button class="slider-btn next" type="button" data-slide-next aria-label="Next story">&rsaquo;</button>
    </div>

    <div class="news-shell home-shell">
        <x-ad-slot :ads="$ads" placement="header_ad" label="Header responsive ad" />
        <div class="market-strip"><strong>Markets</strong><span>Nifty 50: 22,410.20</span><span>Sensex: 73,880.70</span><span>Gold: 72,450</span><span>USD/INR: 83.45</span></div>

        <section class="spotlight-grid reveal">
            <div class="top-headlines-panel">
                <div class="section-head"><div><p class="eyebrow">Trending Now</p><h2>Top Headlines</h2></div></div>
                <div class="headline-mosaic">
                    @foreach($topHeadlines->take(6) as $post)
                        <article class="mosaic-card @if($loop->first) large @endif">
                            @if($post->featured_image || $post->image)<img src="{{ asset('storage/'.($post->featured_image ?: $post->image)) }}" alt="{{ $post->title }}" loading="lazy" decoding="async">@endif
                            <div><span>{{ $post->category?->name }}</span><h3><a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a></h3></div>
                        </article>
                    @endforeach
                </div>
            </div>
            <aside class="sidebar active-sidebar">
                <h2>Most Read</h2>
                @foreach($mostRead as $post)
                    <a class="trend" href="{{ route('blog.show', $post) }}"><strong>{{ $loop->iteration }}</strong><span>{{ $post->title }}<small>{{ number_format($post->views_count) }} views · {{ $post->reading_time }} min</small></span></a>
                @endforeach
                <x-ad-slot :ads="$ads" placement="sidebar_ad" label="Sidebar ad" />
            </aside>
        </section>

        <section class="fresh-section reveal">
            <div class="section-head"><div><p class="eyebrow">Latest</p><h2>Fresh News Feed</h2></div><a href="{{ route('search') }}">View all</a></div>
            <div class="fresh-grid">
                @foreach($latestBlogs->take(7) as $post)
                    <article class="fresh-card @if($loop->first) lead-fresh @endif">
                        <a class="story-thumb @unless($post->featured_image || $post->image) placeholder @endunless" href="{{ route('blog.show', $post) }}">
                            @if($post->featured_image || $post->image)
                                <img src="{{ asset('storage/'.($post->featured_image ?: $post->image)) }}" alt="{{ $post->featured_image_alt ?: $post->title }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}" decoding="async">
                            @else
                                <span>{{ strtoupper(substr($post->category?->name ?? 'MN', 0, 2)) }}</span>
                            @endif
                            <b>{{ $post->category?->name ?? 'News' }}</b>
                        </a>
                        <div class="fresh-copy">
                            <span>{{ optional($post->published_at)->format('M d, Y') }} · {{ number_format($post->views_count) }} views · {{ $post->reading_time }} min</span>
                            <h3><a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a></h3>
                            <p>{{ $post->excerpt }}</p>
                        </div>
                    </article>
                    @if($loop->iteration === 4)<x-ad-slot :ads="$ads" placement="in_content_ad" label="In-content responsive ad" />@endif
                @endforeach
            </div>
        </section>

        <section class="content-grid reveal">
            <div>
                <div class="section-head"><div><p class="eyebrow">Recommended</p><h2>Recommended News</h2></div></div>
                <div class="category-showcase compact">
                    @foreach($recommendedPosts as $post)
                        <article class="card story-card"><span>{{ $post->category?->name }} · {{ $post->author?->name ?? 'News Desk' }}</span><h3><a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a></h3><p>{{ $post->excerpt }}</p></article>
                    @endforeach
                </div>
            </div>
            <aside class="sidebar active-sidebar">
                <h2>Editor's Pick</h2>
                @foreach($editorPicks as $post)
                    <a class="mini-pick" href="{{ route('blog.show', $post) }}"><span>{{ $post->category?->name }}</span><strong>{{ $post->title }}</strong></a>
                @endforeach
                <div class="newsletter glass"><h3>Morning Briefing</h3><p>Smart reads from MILLENIUMNEWSROOM, delivered daily.</p><input placeholder="Email address"><button class="btn primary">Subscribe</button></div>
            </aside>
        </section>

        <section class="category-band popular-cats reveal">
            <div class="section-head"><div><p class="eyebrow">Explore</p><h2>Popular Categories</h2></div></div>
            <div class="pill-grid">@foreach($popularCategories as $category)<a href="{{ route('category.show', $category) }}">{{ $category->name }} <span>{{ $category->blogs_count }}</span></a>@endforeach</div>
        </section>

        @foreach($categories as $category)
            @if($category->blogs->isNotEmpty())
            <section class="category-band reveal">
                <div class="section-head"><div><p class="eyebrow">{{ $category->name }}</p><h2>{{ $category->name }} Highlights</h2></div><a href="{{ route('category.show', $category) }}">More</a></div>
                <div class="category-showcase">
                    @foreach($category->blogs as $post)
                        <article class="card story-card"><span>{{ $post->category?->name }} · {{ $post->author?->name ?? 'News Desk' }}</span><h3><a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a></h3><p>{{ $post->excerpt }}</p></article>
                    @endforeach
                </div>
            </section>
            @endif
        @endforeach

        <section class="category-band tag-section reveal">
            <div class="section-head"><div><p class="eyebrow">Topics</p><h2>Popular Tags</h2></div></div>
            <div class="tag-cloud">@foreach($popularTags as $tag)<a href="{{ route('search', ['q' => $tag->name]) }}">#{{ $tag->name }}</a>@endforeach</div>
        </section>

        <section class="category-band visual-section reveal">
            <div class="section-head"><div><p class="eyebrow">Video & Photos</p><h2>Latest Visual Stories</h2></div></div>
            <div class="card-grid">@foreach($featuredPosts->take(3) as $post)<article class="card video-card"><span>Video</span><h3>{{ $post->title }}</h3><p>{{ $post->excerpt }}</p></article>@endforeach</div>
        </section>
        <x-ad-slot :ads="$ads" placement="footer_ad" label="Footer responsive ad" />
    </div>
</section>
@push('scripts')
<script>
(() => {
    const slides = [...document.querySelectorAll('.hero-slide')];
    let index = 0;
    const show = next => {
        if (!slides.length) return;
        slides[index]?.classList.remove('active');
        index = (next + slides.length) % slides.length;
        slides[index]?.classList.add('active');
    };
    document.querySelector('[data-slide-next]')?.addEventListener('click', () => show(index + 1), {passive:true});
    document.querySelector('[data-slide-prev]')?.addEventListener('click', () => show(index - 1), {passive:true});
    if (slides.length > 1 && !matchMedia('(prefers-reduced-motion: reduce)').matches) setInterval(() => show(index + 1), 6200);
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(entries => entries.forEach(entry => entry.target.classList.toggle('visible', entry.isIntersecting)), {threshold:.12});
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    } else {
        document.querySelectorAll('.reveal').forEach(el => el.classList.add('visible'));
    }
})();
</script>
@endpush
@endsection
