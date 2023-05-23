<?php

namespace App\Models;

use App\Models\Transaction;
use App\Traits\GetAttribute;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use HasFactory , HasApiTokens , Notifiable , GetAttribute;

    protected $table = 'clients';
    public $timestamps = true;

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $fillable = [
        'name',
        'email',
        'number',
        'push_token',
        'image',
        'userType',
        'balance',
        'verification_code',
        'number_verified_at'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->multiple_attachment = true;
        $this->multiple_attachment_usage = ['default', 'bdf-file'];
    }
    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    public function carts()
    {
        return $this->hasMany('App\Models\Cart');
    }

    public function notifications(){
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function addresses(){
        return $this->hasMany(Address::class, 'user_id');
    }

    public function wallet()
    {
        return $this->hasOne('App\Models\Wallet');
    }

    public function send_trans(){
        return $this->hasMany(Transaction::class , 'sender_id');
    }
    
    public function recieve_trans(){
        return $this->hasMany(Transaction::class , 'reciver_id');
    }

}
