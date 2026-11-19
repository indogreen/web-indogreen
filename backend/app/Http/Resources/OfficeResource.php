<?php

namespace App\Http\Resources;

use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Office
 */
class OfficeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'office_type' => $this->office_type->value,
            'office_type_label' => $this->office_type->label(),
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'map_embed_url' => $this->map_embed_url,
            'sort_order' => $this->sort_order,
        ];
    }
}
