<?php

namespace App\Providers;

use App\Models\NavigationItem;
use App\Models\FooterSetting;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            try {
                $hasSettings = Schema::hasTable('settings');
                $hasNavigation = Schema::hasTable('navigation_items');
                $hasFooter = Schema::hasTable('footer_settings');
            } catch (Throwable) {
                $hasSettings = false;
                $hasNavigation = false;
                $hasFooter = false;
            }

            $view->with('siteName', $hasSettings ? Setting::getValue('site_name', 'MILLENIUMNEWSROOM') : 'MILLENIUMNEWSROOM');
            $view->with('siteTitle', $hasSettings ? Setting::getValue('site_title', 'MILLENIUMNEWSROOM | Professional News Portal') : 'MILLENIUMNEWSROOM | Professional News Portal');
            $view->with('tagline', $hasSettings ? Setting::getValue('tagline', 'Business, markets and technology journalism') : 'Business, markets and technology journalism');
            $view->with('primaryColor', $hasSettings ? Setting::getValue('primary_color', '#1f1a12') : '#1f1a12');
            $view->with('secondaryColor', $hasSettings ? Setting::getValue('secondary_color', '#c79a2b') : '#c79a2b');
            $view->with('logo', $hasSettings ? Setting::getValue('logo') : null);
            $view->with('assetVersion', $this->assetVersion());
            $view->with('navigationItems', $hasNavigation ? $this->navigationItems() : collect());
            $view->with('footerSetting', $hasFooter ? FooterSetting::current() : new FooterSetting([
                'company_name' => 'MILLENIUMNEWSROOM',
                'email' => 'info@MILLENIUMNEWSROOM.com',
                'phone' => '+91 9876543210',
                'address' => 'New Delhi, India',
                'copyright_text' => '(c) '.date('Y').' MILLENIUMNEWSROOM. All rights reserved.',
            ]));
        });
    }

    private function assetVersion(): string
    {
        $files = ['css/app.css', 'css/news.css', 'css/footer.css', 'js/app.js'];

        $latest = collect($files)
            ->map(fn ($file) => public_path($file))
            ->filter(fn ($path) => is_file($path))
            ->map(fn ($path) => filemtime($path))
            ->max();

        return (string) ($latest ?: time());
    }

    private function navigationItems()
    {
        $categoryUrls = [
            'News' => '/category/news',
            'Markets' => '/category/markets',
            'Technology' => '/category/technology',
            'Companies' => '/category/companies',
            'Politics' => '/category/politics',
            'Opinion' => '/category/opinion',
            'Sports' => '/category/sports',
            'Lifestyle' => '/category/lifestyle',
        ];

        return NavigationItem::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($item) use ($categoryUrls) {
                if (isset($categoryUrls[$item->label])) {
                    $item->url = $categoryUrls[$item->label];
                }

                return $item;
            });
    }
}
