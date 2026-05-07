@extends('admin.layout')

@section('content')
<div class="admin-title"><div><span class="kicker">Homepage Builder</span><h2>Homepage Sections</h2></div></div>
<div class="panel">
@foreach($sections as $section)
    <div class="row-line">
        <div><strong>{{ ucfirst(str_replace('_', ' ', $section->key)) }}</strong><span>{{ $section->title }} · Order {{ $section->sort_order }} · {{ $section->is_active ? 'Active' : 'Hidden' }}</span></div>
        <a class="btn small" href="{{ route('admin.homepage.edit', $section) }}">Edit</a>
    </div>
@endforeach
</div>
@endsection
