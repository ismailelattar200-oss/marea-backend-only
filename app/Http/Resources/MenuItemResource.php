<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'category_id'    => $this->category_id,
            'name'           => $this->name,
            'description'    => $this->description,
            'price'          => (float) $this->price,
            'image_url'      => $this->image_url,
            'display_number' => $this->display_number,
            'is_available'   => $this->is_available,
            'is_featured'    => $this->is_featured,
            'category'       => new CategoryResource($this->whenLoaded('category')),
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
        ];
    }
}
