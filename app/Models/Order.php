<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [       
        'order_no',
        'customer_name',
        'company',
        'address',
        'tel',
        'total_price',
        'status',
    ];

    public function orderdetails() {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
