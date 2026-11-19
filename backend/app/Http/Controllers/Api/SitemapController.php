<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\Solution;
use App\Services\ContentCacheService;
use Illuminate\Http\JsonResponse;

class SitemapController extends BaseApiController
{
    /**
     * Get sitemap entries for search engines and frontend sitemap generation.
     */
    public function index(): JsonResponse
    {
        $entries = ContentCacheService::remember('sitemap_entries', [], function () {
            $frontendUrl = rtrim((string) config('app.frontend_url', 'https://indogreen.id'), '/');
            $now = now()->toIso8601String();

            $list = [
                [
                    'url' => "{$frontendUrl}/",
                    'lastmod' => $now,
                    'changefreq' => 'weekly',
                    'priority' => 1.0,
                ],
                [
                    'url' => "{$frontendUrl}/produk",
                    'lastmod' => $now,
                    'changefreq' => 'daily',
                    'priority' => 0.9,
                ],
                [
                    'url' => "{$frontendUrl}/solusi",
                    'lastmod' => $now,
                    'changefreq' => 'weekly',
                    'priority' => 0.9,
                ],
                [
                    'url' => "{$frontendUrl}/kontak",
                    'lastmod' => $now,
                    'changefreq' => 'monthly',
                    'priority' => 0.7,
                ],
            ];

            // Kategori Produk
            foreach (Category::active()->get() as $category) {
                $list[] = [
                    'url' => "{$frontendUrl}/produk/{$category->slug}",
                    'lastmod' => $category->updated_at?->toIso8601String() ?? $now,
                    'changefreq' => 'weekly',
                    'priority' => 0.8,
                ];
            }

            // Produk Detail
            $products = Product::active()->with('category')->get();
            foreach ($products as $product) {
                $categorySlug = $product->category ? $product->category->slug : 'umum';
                $list[] = [
                    'url' => "{$frontendUrl}/produk/{$categorySlug}/{$product->slug}",
                    'lastmod' => $product->updated_at?->toIso8601String() ?? $now,
                    'changefreq' => 'weekly',
                    'priority' => 0.8,
                ];
            }

            // Solusi Detail
            foreach (Solution::active()->get() as $solution) {
                $list[] = [
                    'url' => "{$frontendUrl}/solusi/{$solution->slug}",
                    'lastmod' => $solution->updated_at?->toIso8601String() ?? $now,
                    'changefreq' => 'monthly',
                    'priority' => 0.8,
                ];
            }

            // Halaman Statis
            foreach (Page::active()->get() as $page) {
                $list[] = [
                    'url' => "{$frontendUrl}/{$page->slug}",
                    'lastmod' => $page->updated_at?->toIso8601String() ?? $now,
                    'changefreq' => 'monthly',
                    'priority' => 0.6,
                ];
            }

            return $list;
        });

        return $this->respondOk($entries, 'Daftar entri sitemap berhasil diambil.');
    }
}
