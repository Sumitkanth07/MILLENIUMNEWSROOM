<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin | {{ $siteName ?? 'MILLENIUMNEWSROOM' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/news.css') }}">
</head>
<body class="admin-body">
    <aside class="admin-sidebar">
        <h1><span>MILLENIUM</span><span>NEWSROOM</span></h1>
        <button class="admin-mode-toggle" type="button" data-admin-theme-toggle>Toggle mode</button>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.homepage.index') }}">Homepage Sections</a>
        <a href="{{ route('admin.blogs.index') }}">Post Management</a>
        <a href="{{ route('admin.categories.index') }}">Categories</a>
        <a href="{{ route('admin.authors.index') }}">Authors</a>
        <a href="{{ route('admin.pages.index') }}">Page Builder</a>
        <a href="{{ route('admin.media.index') }}">Media Library</a>
        <a href="{{ route('admin.ads.index') }}">Ad Management</a>
        <a href="{{ route('admin.branding.edit') }}">Branding</a>
        <a href="{{ route('admin.navigation.index') }}">Navigation</a>
        <a href="{{ route('admin.footer.edit') }}">Footer Settings</a>
        <a href="{{ route('admin.redirects.index') }}">Redirects</a>
        <form method="POST" action="{{ route('admin.logout') }}">@csrf<button>Logout</button></form>
    </aside>
    <main class="admin-main">
        @if(session('status'))<div class="notice">{{ session('status') }}</div>@endif
        @if($errors->any())<div class="notice danger">{{ $errors->first() }}</div>@endif
        @yield('content')
    </main>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
    (() => {
        const key = 'millenium-admin-theme';
        document.documentElement.dataset.adminTheme = localStorage.getItem(key) || 'dark';
        document.querySelector('[data-admin-theme-toggle]')?.addEventListener('click', () => {
            const next = document.documentElement.dataset.adminTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.dataset.adminTheme = next;
            localStorage.setItem(key, next);
        });
    })();
    </script>
    @stack('scripts')
</body>
</html>
