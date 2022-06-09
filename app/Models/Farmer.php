<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    protected $fillable = [       
        'user_id',
        'address',
        'area',
        'lat',
        'long',
        'received_amount',
        'enterprise_id',
    ];

    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function enterprises() {
        return $this->belongsTo(Enterprise::class, 'enterprise_id');
    }

    public function getCurrentPlants()
    {
        return $this->hasMany(Plant::class, 'farmer_id')->orderBy('created_at', 'desc');
        // return $this->hasMany(Plant::class, 'farmer_id');
    }

    public function plants()
    {
        return $this->hasMany(Plant::class, 'farmer_id')->orderBy('created_at', 'desc')->take(5);
        // return $this->hasMany(Plant::class, 'farmer_id');
    }
}
