@extends('admin.layout')
@section('content')
<div class="admin-title"><h2>Page Builder</h2><a class="btn primary" href="{{ route('admin.pages.create') }}">New Page</a></div>
<div class="panel">
@foreach($pages as $page)
    <div class="row-line"><div><strong>{{ $page->title }}</strong><span>/{{ $page->slug }} · {{ $page->is_published ? 'Published' : 'Draft' }}</span></div><div class="actions"><a class="btn small" href="{{ route('admin.pages.edit', $page) }}">Edit</a><form method="POST" action="{{ route('admin.pages.destroy', $page) }}">@csrf @method('DELETE')<button class="btn small danger">Delete</button></form></div></div>
@endforeach
</div>
{{ $pages->links() }}
@endsection
