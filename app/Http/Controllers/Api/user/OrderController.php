<?php

namespace App\Http\Controllers\Api\user;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\helpers\helper;
use App\Models\Product;
use App\Models\Service;
use App\Events\newOrder;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\UserRegistration;
use App\Notifications\NewOrderNoti;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->helper = new helper();
    }

    public function placeOrder(Request $request)
    {
        $validate = $request->validate([
            'payment_method' => 'required',
            'address_id' => 'required:exists,addresses',
            'total_del_price' => 'required',
            'description' => 'required',
            'service_id' => 'required|exists:services,id',
        ]);
        $address = auth()->user()->addresses()->where('user_id', auth()->user()->id)->first();
        $service = Service::findorFail($validate['service_id']);
        $order = new Order();
        $order->payment_method = $validate['payment_method'];
        $order->description = $validate['description'];
        $order->total_del_price = $validate['total_del_price'];
        $order->address_id = $address->id;
        $order->service_id = $service->id;
        $order->client_id = auth()->user()->id;
        $order->ref_number = uniqid();

        $order->save();

        event(new newOrder());

        $users = User::where('id', 1)->first();
        $user_create = Auth::user()->number;
        Notification::send($users, new NewOrderNoti($order->id, $user_create));

        return $this->helper->ResponseJson(1, __('apis.success'), $order);
    }

    // public function checkout(Request $request)
    // {
    //     $validate = $request->validate([
    //         'payment_method' => 'required',
    //         'address_id' => 'required:exists,addresses'
    //     ]);
    //     $order = new Order();
    //     $order->payment_method = $validate['payment_method'];
    //     $order->client_id = auth()->user()->id;
    //     $order->save();
    //     $cart = Cart::where('client_id', 1)->get();
    //     if ($cart != '[]') {

    //         foreach ($cart as $item) {
    //             OrderItem::create([
    //                 'product_id' => $item->product_id,
    //                 'total_price' => $item->del_price,
    //                 'order_id' => $order->id,

    //             ]);
    //             $product = Product::where('id', $item->product_id)->first();
    //             $price = Cart::where('id', $item->id)->first();
    //             $collectCartPrice[] = $item->del_price;
    //         }
    //         $total_cost = array_sum($collectCartPrice);


    //         $order->update([
    //             'total_del_price' => $total_cost,
    //             'address_id' => $request->address_id,
    //             'ref_number' => Str::random(10)
    //         ]);
    //         $cartItems = Cart::where('client_id', auth()->user()->id)->get();

    //         Cart::destroy($cartItems);
    //         return $this->helper->ResponseJson(1, __('apis.success'), $order);
    //     } else {
    //         return $this->helper->ResponseJson(1, __('apis.cart_is_empty'), []);
    //     }
    // }
}
