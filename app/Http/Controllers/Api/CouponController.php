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
            ->first();

        if ($coupon) {
            if ($coupon->getRemainingUsageCount() > 0) {
                return response()->json(['coupon' => new CouponResource($coupon)], 200);
            } else {
                return response()->json(['error' => 'Coupon expired'], 403);
            }
        } else {
            return response()->json(['error' => 'Coupon not found'], 404);
        }
    }
}
