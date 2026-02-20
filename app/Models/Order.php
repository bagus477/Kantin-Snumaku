<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'menu_name',
        'qty',
        'base_amount',
        'extra_amount',
        'total_amount',
        'payment_method',
        'status',
        'alasan_tolak',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
