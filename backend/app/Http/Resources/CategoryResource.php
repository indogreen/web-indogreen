<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Support\MediaUrlHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Category
 */
class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $media = $this->getFirstMedia('category_image');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'icon_name' => $this->icon_name,
            'sort_order' => $this->sort_order,
            'products_count' => $this->whenCounted('products', $this->products_count),
            'image' => MediaUrlHelper::formatMedia($media, $this->name),
        ];
    }
}
