<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons',
            'discount' => 'required|numeric',
            'owner' => 'required',
            'owner_ratio' => 'required|numeric',
            'maximum_usage' => 'nullable|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        Coupon::create($request->all());
        return redirect()->route('coupons')->with('Add', 'Coupon created successfully!');
    }

    public function edit($id)
    {
        $coupon = Coupon::find($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::find($id);
        $request->validate([
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'discount' => 'required|numeric',
            'owner' => 'required',
            'owner_ratio' => 'required|numeric',
            'maximum_usage' => 'nullable|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        $coupon->update($request->all());
        return redirect()->route('coupons')->with('edit', 'Coupon updated successfully!');
    }

    public function destroy(string $id)
    {
        $coupon = Coupon::find($id);
        $coupon->delete();
        return redirect()->route('coupons.index')->with('delete', 'Coupon deleted successfully!');
    }
}
