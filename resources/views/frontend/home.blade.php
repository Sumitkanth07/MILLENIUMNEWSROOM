@extends('frontend.layout')

@section('content')
@php
    $hero = $sections['hero'] ?? null;
    $about = $sections['about'] ?? null;
    $serviceSection = $sections['services'] ?? null;
    $projectSection = $sections['projects'] ?? null;
    $contact = $sections['contact'] ?? null;
@endphp

<section id="home" class="hero">
    <div class="hero-copy">
        <p class="eyebrow">{{ $hero?->subtitle ?? 'Navurja Solar Energy Solutions' }}</p>
        <h1>{{ $hero?->title ?? $tagline }}</h1>
        <p>{{ $hero?->content }}</p>
        <div class="hero-actions">
            <a class="btn primary" href="{{ $hero?->button_url ?? route('calculator.show') }}">{{ $hero?->button_text ?? 'Calculate Savings' }}</a>
            <a class="btn ghost" href="#contact">Get Consultation</a>
        </div>
    </div>
    <div class="hero-panel">
        @if($hero?->image)
            <img class="section-image hero-image" src="{{ asset('storage/'.$hero->image) }}" alt="{{ $hero->title }}">
        @else
            <span>Solar ROI</span>
            <strong>25+ Years</strong>
            <p>Clean power, lower bills and a brighter operating future.</p>
        @endif
    </div>
</section>

<section id="about" class="section split">
    <div>
        <p class="eyebrow">{{ $about?->subtitle }}</p>
        <h2>{{ $about?->title }}</h2>
        @if($about?->image)
            <img class="section-image" src="{{ asset('storage/'.$about->image) }}" alt="{{ $about->title }}">
        @endif
    </div>
    <p>{{ $about?->content }}</p>
</section>

<section id="services" class="section">
    <p class="eyebrow">{{ $serviceSection?->subtitle }}</p>
    <h2>{{ $serviceSection?->title }}</h2>
    @if($serviceSection?->image)
        <img class="section-image wide-image" src="{{ asset('storage/'.$serviceSection->image) }}" alt="{{ $serviceSection->title }}">
    @endif
    <div class="card-grid">
        @foreach($services as $service)
            <article class="card">
                <span class="icon-dot">{{ strtoupper(substr($service->title, 0, 1)) }}</span>
                <h3>{{ $service->title }}</h3>
                <p>{{ $service->description }}</p>
            </article>
        @endforeach
    </div>
</section>

<section id="projects" class="section soft">
    <p class="eyebrow">{{ $projectSection?->subtitle }}</p>
    <h2>{{ $projectSection?->title }}</h2>
    @if($projectSection?->image)
        <img class="section-image wide-image" src="{{ asset('storage/'.$projectSection->image) }}" alt="{{ $projectSection->title }}">
    @endif
    <div class="card-grid">
        @foreach($projects as $project)
            <article class="card project-card">
                <div class="project-art"></div>
                <h3>{{ $project->title }}</h3>
                <p>{{ $project->location }} @if($project->capacity) • {{ $project->capacity }} @endif</p>
                <small>{{ $project->description }}</small>
            </article>
        @endforeach
    </div>
</section>

<section class="section">
    <div class="section-head">
        <div><p class="eyebrow">Insights</p><h2>Solar Blog</h2></div>
        <a href="{{ route('blog.index') }}">View all</a>
    </div>
    <div class="card-grid">
        @forelse($latestBlogs as $blog)
            <article class="card">
                <h3><a href="{{ route('blog.show', $blog) }}">{{ $blog->title }}</a></h3>
                <p>{{ $blog->excerpt }}</p>
            </article>
        @empty
            <article class="card"><h3>Blog is ready</h3><p>Create your first post from the admin panel.</p></article>
        @endforelse
    </div>
</section>

<section id="contact" class="section contact-band">
    <div>
        <p class="eyebrow">{{ $contact?->subtitle }}</p>
        <h2>{{ $contact?->title }}</h2>
        <p>{{ $contact?->content }}</p>
        @if($contact?->image)
            <img class="section-image contact-image" src="{{ asset('storage/'.$contact->image) }}" alt="{{ $contact->title }}">
        @endif
    </div>
    <a class="btn primary" href="{{ $contact?->button_url ?? 'mailto:hello@navurja.test' }}">{{ $contact?->button_text ?? 'Contact Navurja' }}</a>
</section>
@endsection
