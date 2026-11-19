<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Support\MediaUrlHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Product
 */
class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $firstMedia = $this->getFirstMedia('gallery');
        $featuredImage = $firstMedia
            ? MediaUrlHelper::formatMedia($firstMedia, $this->name)
            : MediaUrlHelper::formatPath($this->featured_image, $this->name);

        $datasheetMedia = $this->getFirstMedia('datasheet');
        $datasheetUrl = $datasheetMedia
            ? $datasheetMedia->getFullUrl()
            : MediaUrlHelper::formatFileUrl($this->datasheet_pdf);

        $gallery = $this->getMedia('gallery')
            ->map(fn ($m) => MediaUrlHelper::formatMedia($m, $this->name))
            ->values()
            ->all();

        $specsGrouped = $this->specifications
            ->sortBy('sort_order')
            ->groupBy('spec_group')
            ->map(fn ($specs) => $specs->map(fn ($spec) => [
                'key' => $spec->spec_key,
                'value' => $spec->spec_value,
                'unit' => $spec->spec_unit,
            ])->values()->all())
            ->all();

        $solutions = $this->solutions
            ->where('is_active', true)
            ->map(fn ($solution) => [
                'id' => $solution->id,
                'name' => $solution->name,
                'slug' => $solution->slug,
                'system_type' => $solution->system_type,
            ])
            ->values()
            ->all();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'category' => $this->category ? [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ] : null,
            'model_series' => $this->model_series,
            'badge_tag' => $this->badge_tag,
            'short_description' => $this->short_description,
            'full_description' => $this->full_description,
            'featured_image' => $featuredImage,
            'datasheet_pdf_url' => $datasheetUrl,
            'specifications_grouped' => $specsGrouped,
            'gallery' => $gallery,
            'solutions' => $solutions,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'is_featured' => $this->is_featured,
            'sort_order' => $this->sort_order,
        ];
    }
}
