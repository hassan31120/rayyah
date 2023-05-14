<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function index()
    {

        $trans = Transaction::latest()->get();

        return view('admin.transactions.index',compact('trans'));
    }
}
