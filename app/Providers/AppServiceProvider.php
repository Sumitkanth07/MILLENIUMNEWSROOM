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
            $view->with('navigationItems', $hasNavigation ? NavigationItem::where('is_active', true)->orderBy('sort_order')->get() : collect());
            $view->with('footerSetting', $hasFooter ? FooterSetting::current() : new FooterSetting([
                'company_name' => 'MILLENIUMNEWSROOM',
                'email' => 'info@MILLENIUMNEWSROOM.com',
                'phone' => '+91 9876543210',
                'address' => 'New Delhi, India',
                'copyright_text' => '(c) '.date('Y').' MILLENIUMNEWSROOM. All rights reserved.',
            ]));
        });
    }
}
