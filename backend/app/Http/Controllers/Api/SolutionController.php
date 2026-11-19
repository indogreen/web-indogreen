<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\SolutionDetailResource;
use App\Http\Resources\SolutionListResource;
use App\Models\Solution;
use App\Services\ContentCacheService;
use Illuminate\Http\JsonResponse;

class SolutionController extends BaseApiController
{
    /**
     * Get list of all active solar solutions.
     */
    public function index(): JsonResponse
    {
        $solutions = ContentCacheService::remember('solutions_list', [], function () {
            return Solution::query()
                ->active()
                ->ordered()
                ->get();
        });

        return $this->respondOk(SolutionListResource::collection($solutions), 'Daftar solusi EBT berhasil diambil.');
    }

    /**
     * Get solution detail by slug.
     */
    public function show(string $slug): JsonResponse
    {
        $solution = ContentCacheService::remember('solution_detail', ['slug' => $slug], function () use ($slug) {
            return Solution::query()
                ->active()
                ->where('slug', $slug)
                ->with('products')
                ->firstOrFail();
        });

        return $this->respondOk(new SolutionDetailResource($solution), 'Detail solusi sistem berhasil diambil.');
    }
}
