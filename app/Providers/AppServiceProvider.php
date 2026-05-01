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

            $view->with('siteName', $hasSettings ? Setting::getValue('site_name', 'Navurja') : 'Navurja');
            $view->with('siteTitle', $hasSettings ? Setting::getValue('site_title', 'Navurja | Solar Energy Solutions') : 'Navurja | Solar Energy Solutions');
            $view->with('tagline', $hasSettings ? Setting::getValue('tagline', 'Clean Energy for a Better Future') : 'Clean Energy for a Better Future');
            $view->with('primaryColor', $hasSettings ? Setting::getValue('primary_color', '#1f8f45') : '#1f8f45');
            $view->with('secondaryColor', $hasSettings ? Setting::getValue('secondary_color', '#f4b23b') : '#f4b23b');
            $view->with('logo', $hasSettings ? Setting::getValue('logo') : null);
            $view->with('navigationItems', $hasNavigation ? NavigationItem::where('is_active', true)->orderBy('sort_order')->get() : collect());
            $view->with('footerSetting', $hasFooter ? FooterSetting::current() : new FooterSetting([
                'company_name' => 'Navurja',
                'email' => 'info@navurja.com',
                'phone' => '+91 9876543210',
                'address' => 'New Delhi, India',
                'copyright_text' => '© '.date('Y').' Navurja. All rights reserved.',
            ]));
        });
    }
}
