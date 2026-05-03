<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $metaTitle ?? $siteTitle }}</title>
    <meta name="description" content="{{ $metaDescription ?? $tagline }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="{{ $metaTitle ?? $siteTitle }}">
    <meta property="og:description" content="{{ $metaDescription ?? $tagline }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <style>:root{--primary:{{ $primaryColor }};--secondary:{{ $secondaryColor }};}</style>
</head>
<body>
    <header class="site-header">
        <a class="brand" href="{{ route('home') }}">
            @if($logo)<img src="{{ asset('storage/'.$logo) }}" alt="{{ $siteName }} logo">@else<span class="leaf-logo">N</span>@endif
            <span>{{ $siteName }}</span>
        </a>
        <button class="nav-toggle" type="button" aria-label="Open menu">Menu</button>
        <nav class="site-nav">
            @foreach($navigationItems as $item)
                @php
                    $menuUrl = str_starts_with($item->url, '#') && ! request()->routeIs('home')
                        ? route('home').$item->url
                        : $item->url;
                @endphp
                <a href="{{ $menuUrl }}" class="nav-link">{{ $item->label }}</a>
            @endforeach
        </nav>
    </header>

    <main>@yield('content')</main>

    <footer class="footer site-footer">
        <div class="footer-column">
            <strong>{{ $footerSetting->company_name ?? $siteName }}</strong>
            <span>Complete renewable energy services for clean, sustainable power.</span>
            <small>{{ $footerSetting->copyright_text }}</small>
        </div>
        <div class="footer-column">
            <h3>Contact</h3>
            @if($footerSetting->email)
                <a href="mailto:{{ $footerSetting->email }}">{{ $footerSetting->email }}</a>
            @endif
            @if($footerSetting->phone)
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $footerSetting->phone) }}">{{ $footerSetting->phone }}</a>
            @endif
            @if($footerSetting->address)
                <span>{{ $footerSetting->address }}</span>
            @endif
        </div>
        <div class="footer-column">
            <h3>Quick Links</h3>
            <a href="{{ route('blog.index') }}">Blog</a>
            <a href="{{ route('calculator.show') }}">Savings Calculator</a>
            <a href="{{ route('admin.login') }}">Admin</a>
        </div>
    </footer>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
