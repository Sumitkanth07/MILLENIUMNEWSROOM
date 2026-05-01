@extends('admin.layout')

@section('content')
<h2>Homepage Editor</h2>
<div class="panel">
@foreach($sections as $section)
    <div class="row-line">
        <div><strong>{{ ucfirst($section->key) }}</strong><span>{{ $section->title }}</span></div>
        <a class="btn small" href="{{ route('admin.homepage.edit', $section) }}">Edit</a>
    </div>
@endforeach
</div>
@endsection
