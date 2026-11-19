<?php

namespace App\Http\Resources;

use App\Models\HeroSlide;
use App\Support\MediaUrlHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin HeroSlide
 */
class HeroSlideResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $desktopMedia = $this->getFirstMedia('hero_desktop');
        $mobileMedia = $this->getFirstMedia('hero_mobile');

        $desktopImage = $desktopMedia
            ? MediaUrlHelper::formatMedia($desktopMedia, $this->title)
            : MediaUrlHelper::formatPath($this->desktop_image, $this->title);

        $mobileImage = $mobileMedia
            ? MediaUrlHelper::formatMedia($mobileMedia, $this->title)
            : MediaUrlHelper::formatPath($this->mobile_image, $this->title);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'button_text' => $this->button_text,
            'button_url' => $this->button_url,
            'desktop_image' => $desktopImage,
            'mobile_image' => $mobileImage,
            'sort_order' => $this->sort_order,
        ];
    }
}
