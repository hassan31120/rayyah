<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'wallets';

    public function user()
    {
        return $this->belongsTo(Client::class, 'client_id');

    }
}
