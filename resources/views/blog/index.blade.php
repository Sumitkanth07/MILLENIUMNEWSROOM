@extends('frontend.layout')

@section('content')
<section class="page-hero">
    <p class="eyebrow">Navurja Blog</p>
    <h1>Solar energy guides and updates</h1>
    <p>Helpful articles on rooftop solar, business savings and clean-energy decisions.</p>
</section>
<section class="section">
    <div class="card-grid">
        @foreach($blogs as $blog)
            <article class="card">
                @if($blog->image)<img class="thumb" src="{{ asset('storage/'.$blog->image) }}" alt="{{ $blog->title }}">@endif
                <h2><a href="{{ route('blog.show', $blog) }}">{{ $blog->title }}</a></h2>
                <p>{{ $blog->excerpt }}</p>
            </article>
        @endforeach
    </div>
    {{ $blogs->links() }}
</section>
@endsection
