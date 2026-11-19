<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Support\MediaUrlHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Product
 */
class ProductListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $media = $this->getFirstMedia('gallery');
        $image = $media
            ? MediaUrlHelper::formatMedia($media, $this->name)
            : MediaUrlHelper::formatPath($this->featured_image, $this->name);

        $datasheetMedia = $this->getFirstMedia('datasheet');
        $datasheetUrl = $datasheetMedia
            ? $datasheetMedia->getFullUrl()
            : MediaUrlHelper::formatFileUrl($this->datasheet_pdf);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'category_slug' => $this->category?->slug,
            'category_name' => $this->category?->name,
            'model_series' => $this->model_series,
            'badge_tag' => $this->badge_tag,
            'short_description' => $this->short_description,
            'featured_image' => $image,
            'datasheet_pdf_url' => $datasheetUrl,
            'is_featured' => $this->is_featured,
            'sort_order' => $this->sort_order,
        ];
    }
}
