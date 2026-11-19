<?php

namespace App\Http\Resources;

use App\Models\Office;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin SiteSetting
 */
class SiteSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $offices = Office::query()
            ->active()
            ->ordered()
            ->get();

        return [
            'company_name' => $this->company_name,
            'tagline' => $this->tagline,
            'phone' => $this->phone,
            'email' => $this->email,
            'whatsapp' => $this->whatsapp,
            'head_office_address' => $this->head_office_address,
            'representative_office_address' => $this->representative_office_address,
            'social_links' => [
                'facebook' => $this->facebook_url,
                'instagram' => $this->instagram_url,
                'youtube' => $this->youtube_url,
            ],
            'offices' => OfficeResource::collection($offices),
        ];
    }
}
