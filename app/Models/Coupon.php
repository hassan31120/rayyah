<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'discount' => 'decimal:2',
        'owner_ratio' => 'decimal:2',
        'maximum_usage' => 'integer',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'coupon_id');
    }

    public function getCurrentUsageCount()
    {
        return $this->orders()->count();
    }

    public function getRemainingUsageCount()
    {
        return $this->maximum_usage - $this->orders()->count();
    }
}
