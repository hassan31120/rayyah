<?php

namespace App\Http\Controllers\Api\user;

use App\Models\User;
use App\Models\Client;
use App\helpers\helper;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\WalletService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
        $this->helper = new helper();

    }

    public function deposit(Request $request)
    {
        $user = Auth::user();
        $amount = $request->amount;
        $this->walletService->deposit($user, $amount);
        // Redirect to success page or display a success message
        return $this->helper->ResponseJson(1, __('apis.success'), $amount);

    }

    public function withdraw(Request $request)
    {
        $user = Auth::user();
        $amount = $request->amount;
        $this->walletService->withdraw($user, $amount);
        // Redirect to success page or display a success message
        return $this->helper->ResponseJson(1, __('apis.success'), $amount);

    }

    public function balance()
    {
        $user = Auth::user();
        $balance = $this->walletService->getBalance($user);
        // Display the user's balance
    }

    public function sendBalane(Request $request){
        $validate = $request->validate([
            'balance' => 'required',
            'number' => 'required|exists:clients,number',
        ]);
        $sender = auth()->user();
        $reciver = Client::where('number',$validate['number'])->first();
        $transaction = new Transaction();
        if ($sender->wallet->balance >= $request->balance) {
            $sender->wallet->balance -=  $request->balance;
            $sender->wallet->save();
            $transaction->value = $validate['balance'];
            $transaction->sender_id = $sender->id;
            $transaction->reciver_id = $reciver->id;
            $reciver->wallet->increment('balance', $request->balance);
            $transaction->save();

            return $this->helper->ResponseJson(1, __('apis.success'));

        }
        return $this->helper->ResponseJson(1, __('apis.balance_faild'));


    }
}
