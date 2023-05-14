<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Complain;
use App\Models\Contact;
use Illuminate\Http\Request;

class ComplainsController extends Controller
{
    public function send_complain(Request $request){
        $request->validate([
            'email' => 'required|email',
            'description' => 'required',
        ]);
        $data = $request->all();
        Complain::create($data);
        return response()->json([
            'success' => true,
            'message' => 'complain has been sent successfully, thank you for your opinion'
        ], 200);
    }

    public function contact_us(Request $request){
        $request->validate([
            'f_name' => 'required',
            'l_name' => 'required',
            'email' => 'required',
            'number' => 'required',
            'message' => 'required',
        ]);
        $data = $request->all();
        Contact::create($data);
        return response()->json([
            'success' => true,
            'message' => 'contact has been sent successfully, thank you'
        ], 200);
    }
}
