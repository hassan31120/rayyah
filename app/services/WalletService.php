<?php

namespace App\Services;

use App\Models\User;
use App\Models\Client;
use App\Models\Wallet;

class WalletService
{
    public function deposit(Client $user, $amount)
    {
        $walletold = Wallet::where('client_id', $user->id)->first();
        if(!$walletold){
            $walletcreate = new Wallet();
            $walletcreate->client_id = $user->id;
            $walletcreate->save();
        }

        $wallet = $user->wallet;
        $wallet->balance += $amount;
        $wallet->save();
    }

    public function withdraw(Client $user, $amount)
    {
        $wallet = $user->wallet;
        if ($wallet->balance >= $amount) {
            $wallet->balance -= $amount;
            $wallet->save();
        }
    }

    public function getBalance(Client $user)
    {
        return $user->wallet->balance;
    }
}
