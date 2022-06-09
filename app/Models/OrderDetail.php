<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [       
        'order_id',
        'type',
        'unit',
        'buy_amount',
        'buy_price',
        'date_preferred',
    ];

    public function orders() {
        return $this->belongsTo(Order::class, 'id');
    }
}
