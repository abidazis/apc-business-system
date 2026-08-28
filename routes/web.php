<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProductController as PublicProductController;
use App\Http\Controllers\Public\PortfolioController as PublicPortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/produk', [PublicProductController::class, 'index'])->name('public.products.index');
Route::get('/produk/{slug}', [PublicProductController::class, 'show'])->name('public.products.show');

Route::get('/portfolio', [PublicPortfolioController::class, 'index'])->name('public.portfolio.index');
Route::get('/portfolio/{slug}', [PublicPortfolioController::class, 'show'])->name('public.portfolio.show');

Route::view('/tentang', 'public.about')->name('public.about');
Route::view('/faq', 'public.faq')->name('public.faq');
Route::view('/kontak', 'public.contact')->name('public.contact');

// Sitemap
Route::get('/sitemap.xml', [\App\Http\Controllers\Public\SitemapController::class, 'index'])->name('sitemap');

// Named 'login' used by Laravel's auth middleware to redirect guests.
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');

// Override default Laravel login redirect target: auth middleware redirects
// guests to route('login') → /login → /admin/login. Authenticated users on
// /admin/login are bounced to dashboard via AuthController attempt flow.

require __DIR__ . '/admin.php';