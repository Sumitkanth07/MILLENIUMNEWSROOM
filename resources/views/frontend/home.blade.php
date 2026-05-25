@extends('frontend.layout')

@section('content')
<section class="portal-home">
    <div class="hero-slider" data-slider>
        @foreach(($featuredPosts->isNotEmpty() ? $featuredPosts : $topHeadlines)->take(5) as $post)
            <article class="hero-slide @if($loop->first) active @endif">

                @php
                    $heroImage = $post->featured_image ?: $post->image;
                @endphp

                @if($heroImage)

                    <img 
    src="{{ asset($heroImage) }}"
    alt="{{ $post->featured_image_alt ?: $post->title }}"
    loading="{{ $loop->first ? 'eager' : 'lazy' }}"
    decoding="async"
>

                @endif

                <div class="hero-slide-copy">
                    <span class="badge gold">{{ $post->category?->name ?? 'Featured' }}</span>
                    <h1><a href="{{ route('blog.show', ['blog' => $post->slug]) }}">{{ $post->title }}</a></h1>
                    <p>{{ $post->excerpt }}</p>
                    <small>{{ optional($post->published_at)->format('M d, Y') }}</small>
                </div>
            </article>
        @endforeach

        <button class="slider-btn prev" type="button" data-slide-prev aria-label="Previous story">&lsaquo;</button>
        <button class="slider-btn next" type="button" data-slide-next aria-label="Next story">&rsaquo;</button>
    </div>

    <div class="news-shell home-shell">
        <x-ad-slot :ads="$ads" placement="header_ad" label="Header responsive ad" />

        <div class="market-strip">
            <strong>Markets</strong>
            <span>Nifty 50: 22,410.20</span>
            <span>Sensex: 73,880.70</span>
            <span>Gold: 72,450</span>
            <span>USD/INR: 83.45</span>
        </div>

        <section class="spotlight-grid reveal">

            <div class="top-headlines-panel">

                <div class="section-head">
                    <div>
                        <p class="eyebrow">Trending Now</p>
                        <h2>Top Headlines</h2>
                    </div>
                </div>

                <div class="headline-mosaic">

                    @foreach($topHeadlines->take(6) as $post)

                        @php
                            $topImage = $post->featured_image ?: $post->image;
                        @endphp

                        <article class="mosaic-card @if($loop->first) large @endif">

                            @if($topImage)

                                <img 
    src="{{ asset($topImage) }}"
    alt="{{ $post->title }}"
    loading="lazy"
    decoding="async"
>
                            @endif

                            <div>
                                <span>{{ $post->category?->name }}</span>
                                <h3>
                                    <a href="{{ route('blog.show', ['blog' => $post->slug]) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                            </div>

                        </article>

                    @endforeach

                </div>
            </div>

            <aside class="sidebar active-sidebar">

                <h2>Most Read</h2>

                @foreach($mostRead as $post)

                    <a class="trend" href="{{ route('blog.show', ['blog' => $post->slug]) }}">
                        <strong>{{ $loop->iteration }}</strong>

                        <span>
                            {{ $post->title }}

                            <small>
                                {{ $post->reading_time }} min
                            </small>
                        </span>
                    </a>

                @endforeach

                <x-ad-slot :ads="$ads" placement="sidebar_ad" label="Sidebar ad" />

            </aside>

        </section>

        <section class="fresh-section reveal">

            <div class="section-head">
                <div>
                    <p class="eyebrow">Latest</p>
                    <h2>Fresh News Feed</h2>
                </div>

                <a href="{{ route('search') }}">View all</a>
            </div>

            <div class="fresh-grid">

                @foreach($latestBlogs->take(7) as $post)

                    @php
                        $freshImage = $post->featured_image ?: $post->image;
                    @endphp

                    <article class="fresh-card @if($loop->first) lead-fresh @endif">

                        <a class="story-thumb @unless($freshImage) placeholder @endunless" href="{{ route('blog.show', ['blog' => $post->slug]) }}">

                            @if($freshImage)

                                <img 
    src="{{ asset($freshImage) }}"
    alt="{{ $post->featured_image_alt ?: $post->title }}"
    loading="{{ $loop->first ? 'eager' : 'lazy' }}"
    decoding="async"
>

                            @else

                                <span>{{ strtoupper(substr($post->category?->name ?? 'MN', 0, 2)) }}</span>

                            @endif

                            <b>{{ $post->category?->name ?? 'News' }}</b>

                        </a>

                        <div class="fresh-copy">

                            <span>
                                {{ optional($post->published_at)->format('M d, Y') }}
                                {{ $post->reading_time }} min
                            </span>

                            <h3>
                                <a href="{{ route('blog.show', ['blog' => $post->slug]) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>

                            <p>{{ $post->excerpt }}</p>

                        </div>

                    </article>

                    @if($loop->iteration === 4)

                        <x-ad-slot :ads="$ads" placement="in_content_ad" label="In-content responsive ad" />

                    @endif

                @endforeach

            </div>

        </section>

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
