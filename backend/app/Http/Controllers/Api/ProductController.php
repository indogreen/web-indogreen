<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductListResource;
use App\Models\Product;
use App\Services\ContentCacheService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends BaseApiController
{
    /**
     * Get paginated catalog of active products with optional filters.
     */
    public function index(Request $request): JsonResponse
    {
        $params = [
            'category' => $request->query('category'),
            'q' => $request->query('q', $request->query('search')),
            'featured' => $request->query('featured'),
            'page' => $request->integer('page', 1),
            'per_page' => $request->integer('per_page', 12),
        ];

        $result = ContentCacheService::remember('products_catalog', $params, function () use ($request) {
            $query = Product::query()
                ->active()
                ->with('category');

            // Filter kategori berdasarkan slug
            if ($category = $request->query('category')) {
                $query->whereHas('category', fn ($q) => $q->where('slug', $category));
            }

            // Filter pencarian teks bebas (nama, model_series, deskripsi singkat)
            $search = $request->query('q', $request->query('search'));
            if (! empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('model_series', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%");
                });
            }

            // Filter produk unggulan
            if ($request->boolean('featured')) {
                $query->featured();
            }

            $perPage = max(1, min($request->integer('per_page', 12), 100));
            $paginator = $query->ordered()->paginate($perPage);

            return [
                'items' => ProductListResource::collection($paginator->items())->resolve(),
                'meta' => [
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                ],
            ];
        });

        return $this->respondOk(
            $result['items'],
            'Katalog produk berhasil diambil.',
            $result['meta']
        );
    }

    /**
     * Get detailed technical product by category slug and product slug.
     */
    public function show(string $categorySlug, string $productSlug): JsonResponse
    {
        $product = ContentCacheService::remember('product_detail', [
            'category_slug' => $categorySlug,
            'product_slug' => $productSlug,
        ], function () use ($categorySlug, $productSlug) {
            return Product::query()
                ->active()
                ->where('slug', $productSlug)
                ->whereHas('category', fn ($q) => $q->where('slug', $categorySlug))
                ->with(['category', 'specifications', 'solutions'])
                ->firstOrFail();
        });

        return $this->respondOk(new ProductDetailResource($product), 'Detail produk teknis berhasil diambil.');
    }

    /**
     * Get detailed technical product by slug only.
     */
    public function showBySlug(string $slug): JsonResponse
    {
        $product = ContentCacheService::remember('product_detail_slug', ['slug' => $slug], function () use ($slug) {
            return Product::query()
                ->active()
                ->where('slug', $slug)
                ->with(['category', 'specifications', 'solutions'])
                ->firstOrFail();
        });

        return $this->respondOk(new ProductDetailResource($product), 'Detail produk teknis berhasil diambil.');
    }
}
