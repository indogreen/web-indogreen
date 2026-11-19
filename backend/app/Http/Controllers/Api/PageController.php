<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PageResource;
use App\Models\Page;
use App\Services\ContentCacheService;
use Illuminate\Http\JsonResponse;

class PageController extends BaseApiController
{
    /**
     * Get active static page by slug.
     */
    public function show(string $slug): JsonResponse
    {
        $page = ContentCacheService::remember('page_detail', ['slug' => $slug], function () use ($slug) {
            return Page::query()
                ->active()
                ->where('slug', $slug)
                ->firstOrFail();
        });

        return $this->respondOk(new PageResource($page), 'Halaman statis berhasil diambil.');
    }
}
