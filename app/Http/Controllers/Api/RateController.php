<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function rate(Request $request)
    {
        $validatedData = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'delivery_id' => 'required'
        ]);

        $rating = new Rate();
        $rating->user_id = auth('sanctum')->user()->id;
        $rating->delivery_id = $validatedData['delivery_id'];
        $rating->rating = $validatedData['rating'];
        $rating->save();

        $delivery = Client::find($validatedData['delivery_id']);
        $rates = Rate::where('delivery_id', $validatedData['delivery_id'])->get();

        $delivery->rate = $rates->avg('rating');
        $delivery->save();

        return response()->json(['success' => true, 'message' => 'Rating created successfully'], 201);
    }
}
