<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin | {{ $siteName ?? 'Navurja' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="admin-body">
    <aside class="admin-sidebar">
        <h1>Navurja</h1>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.homepage.index') }}">Homepage Editor</a>
        <a href="{{ route('admin.blogs.index') }}">Blog Management</a>
        <a href="{{ route('admin.calculator.edit') }}">Calculator Settings</a>
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
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
