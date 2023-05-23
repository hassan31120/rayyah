<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'push_notifications';
    protected $dates = ['read_at'];

    public function client(){
        return $this->belongsTo(Client::class, 'client_id');
    }
}
