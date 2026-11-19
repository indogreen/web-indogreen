<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\HeroSlideResource;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\SiteSettingResource;
use App\Http\Resources\SolutionListResource;
use App\Models\Category;
use App\Models\HeroSlide;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\Solution;
use App\Services\ContentCacheService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends BaseApiController
{
    /**
     * Get aggregated home page content.
     */
    public function index(Request $request): JsonResponse
    {
        $data = ContentCacheService::remember('home_data', [], function () {
            $heroSlides = HeroSlide::query()->active()->ordered()->get();
            $featuredProducts = Product::query()->active()->featured()->ordered()->take(6)->with('category')->get();
            $solutions = Solution::query()->active()->ordered()->take(5)->get();
            $categories = Category::query()->active()->ordered()->withCount('products')->get();
            $siteSetting = SiteSetting::first() ?? new SiteSetting;

            return [
                'hero_slides' => HeroSlideResource::collection($heroSlides),
                'featured_products' => ProductListResource::collection($featuredProducts),
                'solutions' => SolutionListResource::collection($solutions),
                'categories' => CategoryResource::collection($categories),
                'company' => new SiteSettingResource($siteSetting),
            ];
        });

        return $this->respondOk($data, 'Data beranda berhasil diambil.');
    }
}
