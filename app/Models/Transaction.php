<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'transaction';

    public function sender()
    {
        return $this->belongsTo(Client::class,'sender_id' , 'id');
    }
    public function reciver()
    {
        return $this->belongsTo(Client::class,'reciver_id');
    }
}
