<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_first_name',
        'customer_last_name',
        'customer_phone',
        'customer_email',
        'customer_address',
        'customer_region',
        'customer_city',
        'customer_postal_code',
        'pickup_time',
        'items',
        'subtotal',
        'total',
        'status',
        'type',
        'payment_method',
        'notes',
        'assigned_to',
    ];

    protected function casts(): array
    {
        return [
            'items' => 'array',
            'subtotal' => 'decimal:2',
            'total' => 'decimal:2',
            'pickup_time' => 'datetime',
        ];
    }

    // ── Relationships ───────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedDriver()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    // ── Scopes ──────────────────────────────────────────────

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopePending($query)
    {
        return $query->where('status', 'en_attente');
    }

    // ── Helpers ─────────────────────────────────────────────

    public static function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $lastOrder = static::whereDate('created_at', today())
            ->orderByDesc('id')
            ->first();

        $sequence = $lastOrder
            ? intval(substr($lastOrder->order_number, -3)) + 1
            : 1;

        return sprintf('MAR-%s-%03d', $date, $sequence);
    }
}
