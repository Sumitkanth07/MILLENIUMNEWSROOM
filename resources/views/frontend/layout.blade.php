<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $metaTitle ?? $siteTitle }}</title>
    <meta name="description" content="{{ $metaDescription ?? $tagline }}">
    <meta name="robots" content="{{ $robotsMeta ?? 'index,follow' }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="{{ $metaTitle ?? $siteTitle }}">
    <meta property="og:description" content="{{ $metaDescription ?? $tagline }}">
    <meta name="twitter:card" content="summary_large_image">
    @isset($ogImage)<meta property="og:image" content="{{ $ogImage }}">@endisset
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/news.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <style>:root{--primary:{{ $primaryColor }};--secondary:{{ $secondaryColor }};}</style>
</head>
<body class="news-body">
    <div class="reading-progress" id="readingProgress"></div>
    <div class="utility-bar">
        <span>ePaper</span><span>Subscribe</span><a href="{{ route('search') }}">Search</a><button class="mode-toggle" type="button" data-theme-toggle>Dark</button><a href="{{ route('login') }}">Login</a>
    </div>
    <header class="site-header news-header">
        <a class="brand" href="{{ route('home') }}">
            @if($logo)<img src="{{ asset('storage/'.$logo) }}" alt="{{ $siteName }} logo">@else<span class="leaf-logo">M</span>@endif
            <span>{{ $siteName }}</span>
        </a>
        <button class="nav-toggle" type="button" aria-label="Open menu">Menu</button>
        <nav class="site-nav mega-nav">
            @forelse($navigationItems as $item)
                <a href="{{ $item->url }}" class="nav-link">{{ $item->label }}</a>
            @empty
                @foreach(['News','Markets','Technology','Companies','Politics','Opinion','Sports','Lifestyle'] as $menu)
                    <a href="{{ route('search', ['q' => $menu]) }}" class="nav-link">{{ $menu }}</a>
                @endforeach
            @endforelse
        </nav>
    </header>

    @isset($breakingPosts)
        <div class="ticker"><strong>Breaking</strong><marquee>@foreach($breakingPosts as $post) {{ $post->title }} @if(!$loop->last) • @endif @endforeach</marquee></div>
    @endisset

    <main>@yield('content')</main>

    <footer class="footer site-footer news-footer">
        <div class="footer-column"><strong>{{ $footerSetting->company_name ?? $siteName }}</strong><span>Sharp, fast and independent coverage across business, politics, technology, markets and culture.</span><small>{{ $footerSetting->copyright_text }}</small></div>
        <div class="footer-column"><h3>Categories</h3><a href="{{ route('search', ['q' => 'Markets']) }}">Markets</a><a href="{{ route('search', ['q' => 'Technology']) }}">Technology</a><a href="{{ route('search', ['q' => 'Opinion']) }}">Opinion</a></div>
        <div class="footer-column"><h3>Company</h3><a href="{{ route('page.show', 'about-us') }}">About us</a><a href="{{ route('page.show', 'privacy-policy') }}">Privacy Policy</a><a href="{{ route('page.show', 'terms') }}">Terms</a><a href="{{ route('sitemap.page') }}">Sitemap</a></div>
        <div class="footer-column"><h3>Contact</h3>@if($footerSetting->email)<a href="mailto:{{ $footerSetting->email }}">{{ $footerSetting->email }}</a>@endif @if($footerSetting->phone)<a href="tel:{{ preg_replace('/[^0-9+]/', '', $footerSetting->phone) }}">{{ $footerSetting->phone }}</a>@endif @if($footerSetting->address)<span>{{ $footerSetting->address }}</span>@endif <span class="socials">X · LinkedIn · YouTube · Instagram</span></div>
    </footer>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
    (() => {
        const key = 'millenium-theme';
        const apply = theme => document.documentElement.dataset.theme = theme;
        apply(localStorage.getItem(key) || 'light');
        document.querySelectorAll('[data-theme-toggle]').forEach(btn => btn.addEventListener('click', () => {
            const next = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
            localStorage.setItem(key, next); apply(next); btn.textContent = next === 'dark' ? 'Light' : 'Dark';
        }));
        window.addEventListener('scroll', () => {
            const bar = document.getElementById('readingProgress');
            if (!bar) return;
            const max = document.documentElement.scrollHeight - innerHeight;
            bar.style.width = max > 0 ? (scrollY / max * 100) + '%' : '0%';
        }, {passive:true});
    })();
    </script>
    @stack('scripts')
</body>
</html>
