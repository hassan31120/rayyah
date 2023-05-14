<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo('App\Models\Client','client_id');
    }

    public function products()
    {
        return $this->belongsTo('App\Models\Product','product_id','id');
    }


}
