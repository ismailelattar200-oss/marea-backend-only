<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'order_id',
        'user_id',
        'customer_name',
        'rating',
        'comment',
        'sentiment',
        'complaint_tags',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'complaint_tags' => 'array',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
