<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductListResource;
use App\Models\Category;
use App\Services\ContentCacheService;
use Illuminate\Http\JsonResponse;

class CategoryController extends BaseApiController
{
    /**
     * Get list of all active categories.
     */
    public function index(): JsonResponse
    {
        $categories = ContentCacheService::remember('categories_list', [], function () {
            return Category::query()
                ->active()
                ->ordered()
                ->withCount(['products' => fn ($q) => $q->active()])
                ->get();
        });

        return $this->respondOk(CategoryResource::collection($categories), 'Daftar kategori produk berhasil diambil.');
    }

    /**
     * Get single category by slug along with its active products.
     */
    public function show(string $slug): JsonResponse
    {
        $data = ContentCacheService::remember('category_detail', ['slug' => $slug], function () use ($slug) {
            $category = Category::query()
                ->active()
                ->where('slug', $slug)
                ->withCount(['products' => fn ($q) => $q->active()])
                ->firstOrFail();

            $products = $category->products()
                ->active()
                ->ordered()
                ->with('category')
                ->get();

            return [
                'category' => new CategoryResource($category),
                'products' => ProductListResource::collection($products),
            ];
        });

        return $this->respondOk($data, 'Detail kategori dan daftar produk terkait berhasil diambil.');
    }
}
