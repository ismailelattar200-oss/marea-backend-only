<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'email'       => $this->email,
            'role'        => $this->role,
            'phone'       => $this->phone,
            'vehicle'     => $this->vehicle,
            'avatar'      => $this->avatar,
            'current_lat' => $this->current_lat ? (float) $this->current_lat : null,
            'current_lng' => $this->current_lng ? (float) $this->current_lng : null,
            'created_at'  => $this->created_at,
        ];
    }
}
