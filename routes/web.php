<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\BrandingController;
use App\Http\Controllers\Admin\CalculatorSettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\HomepageSectionController;
use App\Http\Controllers\Admin\ImageUploadController;
use App\Http\Controllers\Admin\NavigationController;
use App\Http\Controllers\Admin\RedirectController as AdminRedirectController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blog:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/savings-calculator', [CalculatorController::class, 'show'])->name('calculator.show');
Route::get('/sitemap.xml', [FrontendController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [FrontendController::class, 'robots'])->name('robots');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('homepage', HomepageSectionController::class)->only(['index', 'edit', 'update']);
        Route::resource('blogs', AdminBlogController::class)->except(['show']);
        Route::get('/calculator-settings', [CalculatorSettingController::class, 'edit'])->name('calculator.edit');
        Route::put('/calculator-settings', [CalculatorSettingController::class, 'update'])->name('calculator.update');
        Route::get('/branding', [BrandingController::class, 'edit'])->name('branding.edit');
        Route::put('/branding', [BrandingController::class, 'update'])->name('branding.update');
        Route::get('/footer', [FooterController::class, 'edit'])->name('footer.edit');
        Route::post('/footer/update', [FooterController::class, 'update'])->name('footer.update');
        Route::resource('navigation', NavigationController::class)->except(['show']);
        Route::resource('redirects', AdminRedirectController::class)->except(['show']);
        Route::post('/upload-image', [ImageUploadController::class, 'store'])->name('upload.image');
        Route::post('/uploads/images', [ImageUploadController::class, 'store'])->name('images.store');
    });
});
