<?php

namespace App\Services;

use App\Models\User;
use App\Models\Wallet;

class WalletService
{
    public function deposit(User $user, $amount)
    {
        $walletold = Wallet::where('user_id', $user->id)->first();
        if(!$walletold){
            $walletcreate = new Wallet();
            $walletcreate->user_id = $user->id;
            $walletcreate->save();
        }
      
        $wallet = $user->wallet;
        $wallet->balance += $amount;
        $wallet->save();
    }

    public function withdraw(User $user, $amount)
    {
        $wallet = $user->wallet;
        if ($wallet->balance >= $amount) {
            $wallet->balance -= $amount;
            $wallet->save();
        }
    }

    public function getBalance(User $user)
    {
        return $user->wallet->balance;
    }
}
