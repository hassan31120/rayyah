<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOffer extends Model
{
    use HasFactory;
    protected $table= 'offer_order';
    protected $guarded = [];


    public function Order()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function delivery(){
        return $this->belongsTo(Client::class , 'delivery_id' , 'id');
    }
}
