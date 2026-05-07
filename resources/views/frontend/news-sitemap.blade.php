<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
    @foreach($blogs as $blog)
        <url>
            <loc>{{ route('blog.show', $blog) }}</loc>
            <news:news>
                <news:publication><news:name>MILLENIUMNEWSROOM</news:name><news:language>en</news:language></news:publication>
                <news:publication_date>{{ optional($blog->published_at)->toAtomString() }}</news:publication_date>
                <news:title>{{ $blog->title }}</news:title>
            </news:news>
        </url>
    @endforeach
</urlset>
