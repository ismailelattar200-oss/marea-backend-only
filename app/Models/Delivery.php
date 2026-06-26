<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'delivery_person_id',
        'assigned_at',
        'picked_up_at',
        'delivered_at',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'picked_up_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }

    // ── Relationships ───────────────────────────────────────

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function deliveryPerson()
    {
        return $this->belongsTo(User::class, 'delivery_person_id');
    }

    // ── Helpers ─────────────────────────────────────────────

    public function getDeliveryTimeMinutes(): ?int
    {
        if ($this->assigned_at && $this->delivered_at) {
            return $this->assigned_at->diffInMinutes($this->delivered_at);
        }
        return null;
    }
}
