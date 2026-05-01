<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\HomepageSection;
use App\Models\NavigationItem;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;

class FrontendController extends Controller
{
    public function home()
    {
        if (! Schema::hasTable('homepage_sections')) {
            return view('frontend.home', [
                'sections' => collect(),
                'services' => collect(),
                'projects' => collect(),
                'latestBlogs' => collect(),
                'metaTitle' => 'Navurja | Solar Energy Solutions',
                'metaDescription' => 'Clean Energy for a Better Future',
            ]);
        }

        return view('frontend.home', [
            'sections' => HomepageSection::where('is_active', true)->orderBy('sort_order')->get()->keyBy('key'),
            'services' => Service::where('is_active', true)->orderBy('sort_order')->get(),
            'projects' => Project::where('is_active', true)->orderBy('sort_order')->get(),
            'latestBlogs' => Blog::where('is_published', true)->latest('published_at')->take(3)->get(),
            'metaTitle' => Setting::getValue('site_title', 'Navurja | Solar Energy Solutions'),
            'metaDescription' => Setting::getValue('meta_description'),
        ]);
    }

    public function sitemap(): Response
    {
        $blogs = Blog::where('is_published', true)->get(['slug', 'updated_at']);
        $xml = view('frontend.sitemap', compact('blogs'))->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        return response("User-agent: *\nAllow: /\nSitemap: ".url('/sitemap.xml')."\n", 200)
            ->header('Content-Type', 'text/plain');
    }
}
