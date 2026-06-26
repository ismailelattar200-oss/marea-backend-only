<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $isStaff = $request->user()?->role === 'staff';

        if ($isStaff) {
            // Staff only needs to see kitchen-relevant order data
            $mappedItems = is_array($this->items) ? collect($this->items)->map(function($item) {
                return [
                    'id' => $item['id'] ?? null,
                    'name' => $item['name'] ?? '',
                    'quantity' => $item['quantity'] ?? 1,
                    'image_url' => $item['image_url'] ?? null,
                ];
            })->toArray() : [];

            return [
                'id'               => $this->id,
                'order_number'     => $this->order_number,
                'items'            => $mappedItems,
                'status'           => $this->status,
                'type'             => $this->type,
                'notes'            => $this->notes, // Allergies and notes
                'created_at'       => $this->created_at,
                'updated_at'       => $this->updated_at,
            ];
        }

        return [
            'id'               => $this->id,
            'order_number'     => $this->order_number,
            'customer_name'    => $this->customer_name,
            'customer_phone'   => $this->customer_phone,
            'customer_email'   => $this->customer_email,
            'customer_address' => $this->customer_address,
            'pickup_time'      => $this->pickup_time?->toISOString(),
            'items'            => $this->items,
            'subtotal'         => (float) $this->subtotal,
            'total'            => (float) $this->total,
            'status'           => $this->status,
            'type'             => $this->type,
            'notes'            => $this->notes,
            'assigned_to'      => $this->assigned_to,
            'assigned_driver'  => new UserResource($this->whenLoaded('assignedDriver')),
            'delivery'         => new DeliveryResource($this->whenLoaded('delivery')),
            'order_items'      => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,
        ];
    }
}
