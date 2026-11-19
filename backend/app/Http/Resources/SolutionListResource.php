<?php

namespace App\Http\Resources;

use App\Models\Solution;
use App\Support\MediaUrlHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Solution
 */
class SolutionListResource extends JsonResource
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

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'system_type' => $this->system_type,
            'summary' => $this->summary,
            'diagram_image' => $diagramImage,
            'sort_order' => $this->sort_order,
        ];
    }
}
