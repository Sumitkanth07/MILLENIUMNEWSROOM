<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Blog;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index', [
            'stats' => [
                'Total Posts' => Blog::count(),
                'Categories' => Category::count(),
                'Authors' => Author::count(),
                'Views' => Blog::sum('views_count'),
            ],
            'recentBlogs' => Blog::with('category')->latest()->take(5)->get(),
            'trendingBlogs' => Blog::with('category')->orderByDesc('views_count')->take(5)->get(),
        ]);
    }
}
