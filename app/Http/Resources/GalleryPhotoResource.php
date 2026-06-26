<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryPhotoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'image_url'     => $this->image_url,
            'category'      => $this->category,
            'caption'       => $this->caption,
            'display_order' => $this->display_order,
            'created_at'    => $this->created_at,
        ];
    }
}
