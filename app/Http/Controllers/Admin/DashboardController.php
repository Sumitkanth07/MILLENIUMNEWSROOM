<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Project;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index', [
            'stats' => [
                'Published Blogs' => Blog::where('is_published', true)->count(),
                'Services' => Service::count(),
                'Projects' => Project::count(),
            ],
            'recentBlogs' => Blog::latest()->take(5)->get(),
        ]);
    }
}
