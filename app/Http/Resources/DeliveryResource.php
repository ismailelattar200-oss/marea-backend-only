<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id,
            'order_id'           => $this->order_id,
            'delivery_person_id' => $this->delivery_person_id,
            'assigned_at'        => $this->assigned_at?->toISOString(),
            'picked_up_at'       => $this->picked_up_at?->toISOString(),
            'delivered_at'       => $this->delivered_at?->toISOString(),
            'status'             => $this->status,
            'notes'              => $this->notes,
            'delivery_time_min'  => $this->getDeliveryTimeMinutes(),
            'delivery_person'    => new UserResource($this->whenLoaded('deliveryPerson')),
            'order'              => new OrderResource($this->whenLoaded('order')),
            'created_at'         => $this->created_at,
            'updated_at'         => $this->updated_at,
        ];
    }
}
