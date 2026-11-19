<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\SolutionListResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Solution;
use App\Services\ContentCacheService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends BaseApiController
{
    /**
     * Search across active products, solutions, and categories.
     */
    public function index(Request $request): JsonResponse
    {
        $q = trim((string) $request->query('q', ''));

        if (blank($q)) {
            return $this->respondOk([
                'products' => [],
                'solutions' => [],
                'categories' => [],
            ], 'Hasil pencarian kosong.');
        }

        $results = ContentCacheService::remember('search_results', ['q' => $q], function () use ($q) {
            $products = Product::query()
                ->active()
                ->with('category')
                ->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('model_series', 'like', "%{$q}%")
                        ->orWhere('short_description', 'like', "%{$q}%");
                })
                ->take(10)
                ->get();

            $solutions = Solution::query()
                ->active()
                ->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('system_type', 'like', "%{$q}%")
                        ->orWhere('summary', 'like', "%{$q}%");
                })
                ->take(5)
                ->get();

            $categories = Category::query()
                ->active()
                ->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                })
                ->take(5)
                ->get();

            return [
                'products' => ProductListResource::collection($products)->resolve(),
                'solutions' => SolutionListResource::collection($solutions)->resolve(),
                'categories' => CategoryResource::collection($categories)->resolve(),
            ];
        });

        return $this->respondOk($results, 'Hasil pencarian berhasil diambil.');
    }
}
