<?php

namespace App\Http\Controllers\Api;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CouponResource;

class CouponController extends Controller
{
    public function getCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        $code = $request->input('code');
        $now = now();

        $coupon = Coupon::where('code', $code)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->where(function ($query) use ($now) {
                $query->whereNull('maximum_usage')
                    ->orWhere('usage_count', '<', $query->raw('maximum_usage'));
            })
            ->first();

        if ($coupon) {
            return response()->json(['coupon' => new CouponResource($coupon)], 200);
        } else {
            return response()->json(['message' => 'Coupon not found or expired'], 404);
        }
    }
}
