<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo('App\Models\Client','client_id');
    }

    public function delivery()
    {
        return $this->belongsTo('App\Models\Client','delivery_id');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service','service_id');
    }

    public function address(){

        return $this->belongsTo('App\Models\Address');
    }

    public function offers(){
        return $this->hasMany(OrderOffer::class);
    }

    public function coupon(){
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

}
