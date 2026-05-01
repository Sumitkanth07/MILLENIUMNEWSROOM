@props([
    'article' => [],
    'variant' => 'standard',
    'showImage' => true,
    'rank' => null,
])

@php
    $category = $article['category'] ?? $article['heading'] ?? 'News';
    $title = $article['title'] ?? 'Untitled story';
    $summary = $article['summary'] ?? null;
    $image = $article['image'] ?? null;
    $readTime = $article['read_time'] ?? null;
    $time = $article['time'] ?? null;
    $isPremium = strtolower($category) === 'premium';
@endphp

<article {{ $attributes->merge(['class' => 'article-card article-card--'.$variant]) }}>
    @if ($rank)
        <span class="article-card__rank">{{ $rank }}</span>
    @endif

    @if ($showImage && $image)
        <a class="article-card__image" href="#">
            <img src="{{ $image }}" alt="{{ $title }}">
        </a>
    @endif

    <div class="article-card__body">
        <div class="article-card__meta-row">
            <span class="section-kicker">{{ $category }}</span>
            @if ($isPremium)
                <span class="premium-badge">Premium</span>
            @endif
        </div>
        <h3><a href="#">{{ $title }}</a></h3>

        @if ($summary && $variant !== 'compact')
            <p>{{ $summary }}</p>
        @endif

        @if ($readTime || $time)
            <div class="article-meta">
                @if ($readTime)
                    <span>{{ $readTime }}</span>
                @endif
                @if ($readTime && $time)
                    <span aria-hidden="true">|</span>
                @endif
                @if ($time)
                    <span>{{ $time }}</span>
                @endif
            </div>
        @endif
    </div>
</article>
