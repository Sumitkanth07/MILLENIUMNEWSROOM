<?php

namespace App\Http\Controllers;

use App\Models\AdPlacement;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Page;
use App\Models\Setting;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class FrontendController extends Controller
{
    public function home()
    {
        if (! Schema::hasTable('blogs')) {
            return view('frontend.home', [
                'leadStory' => null,
                'breakingPosts' => collect(),
                'topHeadlines' => collect(),
                'latestBlogs' => collect(),
                'trendingPosts' => collect(),
                'featuredPosts' => collect(),
                'editorPicks' => collect(),
                'mostRead' => collect(),
                'popularCategories' => collect(),
                'recommendedPosts' => collect(),
                'popularTags' => collect(),
                'categories' => collect(),
                'ads' => collect(),
                'metaTitle' => 'MILLENIUMNEWSROOM | Professional News Portal',
                'metaDescription' => 'MILLENIUMNEWSROOM delivers business, markets and technology journalism.',
            ]);
        }

        $payload = Cache::remember('frontend.home.payload', 90, function () {
            $published = Blog::query()->where('is_published', true)->with(['category', 'author']);

            return [
                'leadStory' => (clone $published)->where('is_featured', true)->latest('published_at')->first()
                    ?: (clone $published)->latest('published_at')->first(),
                'breakingPosts' => (clone $published)->where('is_breaking', true)->latest('published_at')->take(6)->get(),
                'topHeadlines' => (clone $published)->latest('published_at')->take(6)->get(),
                'latestBlogs' => (clone $published)->latest('published_at')->take(12)->get(),
                'trendingPosts' => (clone $published)->where(fn ($q) => $q->where('is_trending', true)->orWhere('views_count', '>', 0))->orderByDesc('is_trending')->orderByDesc('views_count')->latest('published_at')->take(6)->get(),
                'featuredPosts' => (clone $published)->where('is_featured', true)->latest('published_at')->take(4)->get(),
                'editorPicks' => (clone $published)->where('is_featured', true)->orderByDesc('views_count')->take(6)->get(),
                'mostRead' => (clone $published)->orderByDesc('views_count')->take(5)->get(),
                'recommendedPosts' => (clone $published)->latest('views_count')->take(4)->get(),
                'popularTags' => Tag::withCount('blogs')->orderByDesc('blogs_count')->take(12)->get(),
                'popularCategories' => Category::withCount('blogs')->where('is_active', true)->orderByDesc('blogs_count')->take(6)->get(),
                'categories' => Category::with(['blogs' => fn ($query) => $query->where('is_published', true)->latest('published_at')->take(4)])
                    ->where('is_active', true)->orderBy('sort_order')->take(8)->get(),
                'ads' => AdPlacement::where('is_active', true)->get()->keyBy('key'),
                'metaTitle' => Setting::getValue('site_title', 'MILLENIUMNEWSROOM | Professional News Portal'),
                'metaDescription' => Setting::getValue('meta_description', 'MILLENIUMNEWSROOM delivers business, markets, technology and public affairs journalism.'),
            ];
        });

        return view('frontend.home', $payload);
    }

    public function search(Request $request)
    {
        $query = trim((string) $request->query('q'));
        $category = $request->query('category');
        $sort = $request->query('sort', 'latest');

        $posts = Blog::with(['category', 'author'])->where('is_published', true)
            ->when($query, fn ($builder) => $builder->where(fn ($inner) => $inner
                ->where('title', 'like', "%{$query}%")
                ->orWhere('excerpt', 'like', "%{$query}%")
                ->orWhere('content', 'like', "%{$query}%")))
            ->when($category, fn ($builder) => $builder->whereHas('category', fn ($inner) => $inner->where('slug', $category)))
            ->when($sort === 'popular', fn ($builder) => $builder->orderByDesc('views_count'), fn ($builder) => $builder->latest('published_at'))
            ->paginate(10)
            ->withQueryString();

        return view('frontend.search', [
            'posts' => $posts,
            'query' => $query,
            'selectedCategory' => $category,
            'sort' => $sort,
            'categories' => Category::where('is_active', true)->orderBy('name')->get(),
            'metaTitle' => 'Search News | MILLENIUMNEWSROOM',
            'metaDescription' => 'Search latest news, markets, companies, politics, technology and opinion stories on MILLENIUMNEWSROOM.',
        ]);
    }

    public function category(Category $category)
    {
        $posts = $category->blogs()->with(['category', 'author'])->where('is_published', true)->latest('published_at')->paginate(12);

        return view('frontend.category', [
            'category' => $category,
            'featured' => $posts->first(),
            'posts' => $posts,
            'trendingPosts' => Blog::where('is_published', true)->orderByDesc('views_count')->take(5)->get(),
            'metaTitle' => $category->meta_title ?: $category->name.' News | MILLENIUMNEWSROOM',
            'metaDescription' => $category->meta_description ?: 'Latest '.$category->name.' stories and analysis from MILLENIUMNEWSROOM.',
        ]);
    }

    public function htmlSitemap()
    {
        return view('frontend.html-sitemap', [
            'categories' => Category::withCount('blogs')->where('is_active', true)->orderBy('name')->get(),
            'pages' => Page::where('is_published', true)->orderBy('title')->get(),
            'latestPosts' => Blog::where('is_published', true)->latest('published_at')->take(20)->get(),
            'popularPosts' => Blog::where('is_published', true)->orderByDesc('views_count')->take(10)->get(),
            'archives' => Blog::where('is_published', true)->selectRaw("strftime('%Y-%m', published_at) as month")->groupBy('month')->orderByDesc('month')->take(12)->pluck('month'),
            'metaTitle' => 'Sitemap | MILLENIUMNEWSROOM',
            'metaDescription' => 'Browse categories, pages, posts and archives on MILLENIUMNEWSROOM.',
        ]);
    }

    public function page(Page $page)
    {
        abort_unless($page->is_published, 404);

        return view('frontend.page', [
            'page' => $page,
            'metaTitle' => $page->meta_title ?: $page->title.' | MILLENIUMNEWSROOM',
            'metaDescription' => $page->meta_description,
        ]);
    }

    public function sitemap(): Response
    {
        $blogs = Blog::where('is_published', true)->get(['slug', 'updated_at']);
        $categories = Schema::hasTable('categories') ? Category::where('is_active', true)->get(['slug', 'updated_at']) : collect();
        $pages = Schema::hasTable('pages') ? Page::where('is_published', true)->get(['slug', 'updated_at']) : collect();
        $xml = view('frontend.sitemap', compact('blogs', 'categories', 'pages'))->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    public function newsSitemap(): Response
    {
        $blogs = Blog::where('is_published', true)->latest('published_at')->take(1000)->get(['slug', 'title', 'published_at']);
        $xml = view('frontend.news-sitemap', compact('blogs'))->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $rules = Setting::getValue('robots_txt', "User-agent: *\nAllow: /");

        return response($rules."\nSitemap: ".url('/sitemap.xml')."\nSitemap: ".url('/news-sitemap.xml')."\n", 200)
            ->header('Content-Type', 'text/plain');
    }
}
