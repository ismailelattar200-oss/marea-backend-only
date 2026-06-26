<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
        'birthdate',
        'notifications_enabled',
        'language',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'notifications_enabled' => 'boolean',
            'birthdate' => 'date',
        ];
    }

    // ── Relationships ───────────────────────────────────────

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function assignedOrders()
    {
        return $this->hasMany(Order::class, 'assigned_to');
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'delivery_person_id');
    }

    // ── Helpers ─────────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStaff(): bool
    {
        return in_array($this->role, ['admin', 'staff']);
    }

    public function isDelivery(): bool
    {
        return $this->role === 'delivery';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function hasAdminAccess(): bool
    {
        return in_array($this->role, ['admin', 'staff', 'delivery']);
    }
}
