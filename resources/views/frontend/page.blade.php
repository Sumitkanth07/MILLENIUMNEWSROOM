@extends('frontend.layout')
@section('content')
<article class="article">
    @if($page->banner_image)<img class="article-image" src="{{ asset('storage/'.$page->banner_image) }}" alt="{{ $page->title }}">@endif
    <h1>{{ $page->title }}</h1>
    <div class="content">{!! $page->content !!}</div>
</article>
@endsection
