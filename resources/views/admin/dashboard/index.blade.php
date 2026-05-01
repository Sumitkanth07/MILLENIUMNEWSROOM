@extends('admin.layout')

@section('content')
<h2>Dashboard</h2>
<div class="admin-grid">
    @foreach($stats as $label => $value)
        <div class="admin-card"><span>{{ $label }}</span><strong>{{ $value }}</strong></div>
    @endforeach
</div>
<div class="panel">
    <h3>Recent Blogs</h3>
    @foreach($recentBlogs as $blog)<p>{{ $blog->title }} <span class="muted">{{ $blog->is_published ? 'Published' : 'Draft' }}</span></p>@endforeach
</div>
@endsection
