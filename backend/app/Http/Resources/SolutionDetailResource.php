<?php

namespace App\Http\Resources;

use App\Models\Solution;
use App\Support\MediaUrlHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Solution
 */
class SolutionDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $media = $this->getFirstMedia('solution_image');
        $diagramImage = $media
            ? MediaUrlHelper::formatMedia($media, $this->name)
            : MediaUrlHelper::formatPath($this->diagram_image, $this->name);

        $products = $this->products
            ->where('is_active', true)
            ->map(fn ($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'model_series' => $product->model_series,
                'featured_image' => MediaUrlHelper::formatPath($product->featured_image, $product->name),
            ])
            ->values()
            ->all();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'system_type' => $this->system_type,
            'summary' => $this->summary,
            'system_architecture' => $this->system_architecture,
            'included_components' => $this->included_components ?? [],
            'benefits' => $this->benefits ?? [],
            'diagram_image' => $diagramImage,
            'products' => $products,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'sort_order' => $this->sort_order,
        ];
    }
}
