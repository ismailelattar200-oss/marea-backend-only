<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'email'       => $this->email,
            'phone'       => $this->phone,
            'position'    => $this->position,
            'message'     => $this->message,
            'cv_path'     => $this->cv_path,
            'cv_url'      => $this->cv_path ? url('storage/' . $this->cv_path) : null,
            'is_reviewed' => $this->is_reviewed,
            'created_at'  => $this->created_at,
        ];
    }
}
