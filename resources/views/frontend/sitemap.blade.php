<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>{{ url('/') }}</loc></url>
    <url><loc>{{ route('blog.index') }}</loc></url>
    <url><loc>{{ route('calculator.show') }}</loc></url>
    @foreach($blogs as $blog)
        <url><loc>{{ route('blog.show', $blog) }}</loc><lastmod>{{ $blog->updated_at->toDateString() }}</lastmod></url>
    @endforeach
</urlset>
