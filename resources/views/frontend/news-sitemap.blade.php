<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
    @foreach($blogs as $blog)
        <url>
            <loc>{{ $blog->publicUrl() }}</loc>
            <news:news>
                <news:publication><news:name>MILLENNIUM NEWSROOM</news:name><news:language>en</news:language></news:publication>
                <news:publication_date>{{ optional($blog->published_at)->toAtomString() }}</news:publication_date>
                <news:title>{{ $blog->title }}</news:title>
                <news:keywords>{{ $blog->category?->name }}</news:keywords>
            </news:news>
            <lastmod>{{ optional($blog->updated_at)->toAtomString() }}</lastmod>
        </url>
    @endforeach
</urlset>
