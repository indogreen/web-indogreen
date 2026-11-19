<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HealthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\InquiryController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\SitemapController;
use App\Http\Controllers\Api\SolutionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RESTful JSON API Routes v1
|--------------------------------------------------------------------------
|
| Rute publik website resmi PT. Indogreen Technology And Management.
| Seluruh endpoint beroperasi murni sebagai penyedia data JSON tanpa sesi Blade.
|
*/

Route::prefix('v1')->group(function () {
    // 1. Beranda teragregasi
    Route::get('/home', [HomeController::class, 'index']);

    // 2. Profil perusahaan & kontak global
    Route::get('/settings', [SettingController::class, 'index']);
    Route::get('/company', [SettingController::class, 'index']); // Alias sesuai docs/04-api-contract

    // 3. Kategori produk
    Route::get('/product-categories', [CategoryController::class, 'index']);
    Route::get('/product-categories/{slug}', [CategoryController::class, 'show']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{slug}', [CategoryController::class, 'show']);

    // 4. Katalog & Detail Produk
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{category_slug}/{product_slug}', [ProductController::class, 'show']);
    Route::get('/products/{slug}', [ProductController::class, 'showBySlug']);

    // 5. Solusi EBT
    Route::get('/solutions', [SolutionController::class, 'index']);
    Route::get('/solutions/{slug}', [SolutionController::class, 'show']);

    // 6. Halaman Statis
    Route::get('/pages/{slug}', [PageController::class, 'show']);

    // 7. Pencarian global
    Route::get('/search', [SearchController::class, 'index']);

    // 8. Entri sitemap untuk search engines
    Route::get('/sitemap-entries', [SitemapController::class, 'index']);

    // 9. Formulir kontak / penawaran masuk (Throttled 5 req / menit / IP)
    Route::post('/inquiries', [InquiryController::class, 'store'])->middleware('throttle:inquiries');

    // 10. Health check
    Route::get('/health', [HealthController::class, 'index']);
});
