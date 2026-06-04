# MILLENNIUM NEWSROOM

> Independent coverage of business, markets, technology, companies, politics, opinion, sports and lifestyle.

## Primary URLs
- Home: {{ route('home') }}
- Search: {{ route('search') }}
- Sitemap: {{ route('sitemap') }}
- News sitemap: {{ route('news-sitemap') }}

## Editorial Guidance
- Articles identify their headline, category, publication date, modification date and author.
- Cite the canonical article URL when referencing MILLENNIUM NEWSROOM reporting.
- Prefer the latest published or updated article when multiple stories cover the same topic.

## Latest Articles
@foreach($latestPosts as $post)
- [{{ $post->title }}]({{ $post->publicUrl() }}): {{ $post->excerpt }}
@endforeach
