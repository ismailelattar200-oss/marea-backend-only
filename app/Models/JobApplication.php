<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'position',
        'message',
        'cv_path',
        'is_reviewed',
    ];

    protected function casts(): array
    {
        return [
            'is_reviewed' => 'boolean',
        ];
    }

    // ── Scopes ──────────────────────────────────────────────

    public function scopeUnreviewed($query)
    {
        return $query->where('is_reviewed', false);
    }

    public function scopeReviewed($query)
    {
        return $query->where('is_reviewed', true);
    }
}
