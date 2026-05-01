@extends('frontend.layout')

@section('content')
<article class="article">
    <p class="eyebrow">Solar Insights</p>
    <h1>{{ $blog->title }}</h1>
    <p class="muted">{{ optional($blog->published_at)->format('M d, Y') }}</p>
    @if($blog->image)<img class="article-image" src="{{ asset('storage/'.$blog->image) }}" alt="{{ $blog->title }}">@endif
    <div class="content">{!! $blog->content !!}</div>
</article>
@endsection
