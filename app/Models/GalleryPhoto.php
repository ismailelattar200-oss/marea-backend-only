<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_url',
        'category',
        'caption',
        'display_order',
    ];

    protected function casts(): array
    {
        return [
            'display_order' => 'integer',
        ];
    }

    // ── Scopes ──────────────────────────────────────────────

    public function scopeGaleria($query)
    {
        return $query->where('category', 'galeria');
    }

    public function scopePersonal($query)
    {
        return $query->where('category', 'personal');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }
}
