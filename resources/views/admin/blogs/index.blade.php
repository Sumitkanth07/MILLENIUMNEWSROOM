@extends('admin.layout')

@section('content')
<div class="admin-title"><h2>Blog Management</h2><a class="btn primary" href="{{ route('admin.blogs.create') }}">New Blog</a></div>
<div class="panel">
@foreach($blogs as $blog)
    <div class="row-line">
        <div><strong>{{ $blog->title }}</strong><span>/blog/{{ $blog->slug }}</span></div>
        <div class="actions">
            <a class="btn small" href="{{ route('admin.blogs.edit', $blog) }}">Edit</a>
            <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}">@csrf @method('DELETE')<button class="btn small danger">Delete</button></form>
        </div>
    </div>
@endforeach
</div>
{{ $blogs->links() }}
@endsection
