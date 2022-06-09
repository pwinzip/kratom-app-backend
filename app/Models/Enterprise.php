<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    use HasFactory;

    protected $fillable = [
        'regist_no',
        'enterprise_name',
        'agent_id',
        'address',
    ];

    public function users() {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function farmers()
    {
        return $this->hasMany(Farmer::class, 'enterprise_id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'enterprise_id')->orderBy('created_at', 'desc')->take(10);
    }
}
