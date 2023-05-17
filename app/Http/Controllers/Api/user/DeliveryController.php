<?php

namespace App\Http\Controllers\Api\user;

use App\Models\User;
use App\Models\Order;
use App\helpers\helper;
use Illuminate\Http\Request;
use App\Notifications\OrderDeliver;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;
use App\Notifications\OrderAcceptNoti;
use App\Http\Resources\DelOrderResource;
use App\Http\Resources\TrackOrderResource;
use Illuminate\Support\Facades\Notification;

class DeliveryController extends Controller
{
    public function __construct()
    {
        $this->helper = new helper();
    }

    public function listOrders(Request $request)
    {
        $orders = Order::where('status' , 'prending')->get();

        if($request->order_id){
            $order = Order::where('id',$request->order_id)->where('status','pending')->first();
            if($order){
                return $this->helper->ResponseJson(1, __('apis.success'), new TrackOrderResource($order));

            }
            return $this->helper->ResponseJson(0, __('apis.faild'));
        }
        return $this->helper->ResponseJson(1, __('apis.success'), OrderResource::collection($orders));

    }

    public function acceptOrder(Request $request)
    {
        $validate = $request->validate([
            'order_id' =>'required|exists:orders,id',
            'total_service_price' =>'required'
        ]);
        $order = Order::findOrfail($validate['order_id']);
        if($order){
            $order->status = 'on_delivery';
            $order->total_service_price = $validate['total_service_price'];
            $order->total_cost = $validate['total_service_price'] + $order->total_del_price;
            $order->delivery_id = auth()->user()->id;
            $order->save();
            $users = User::where('id', 1)->first();
            $user_create = Auth::user()->name;
            Notification::send($users, new OrderAcceptNoti($order->id, $user_create));

            return $this->helper->ResponseJson(1, __('apis.success'), new TrackOrderResource($order));

        }
        return $this->helper->ResponseJson(0, __('apis.faild'));
    }

    public function finishOrder(Request $request)
    {
        
        $validate = $request->validate([
            'order_id' =>'required|exists:orders,id',
        ]);
        $order = Order::findOrfail($validate['order_id']);
        if($order){
            $order->status = 'done';
            $order->save();
            $users = User::where('id', 1)->first();
            $user_create = Auth::user()->name;
            Notification::send($users, new OrderDeliver($order->id, $user_create));

            return $this->helper->ResponseJson(1, __('apis.success'));
        }
        return $this->helper->ResponseJson(0, __('apis.faild'));

    }

    public function myOrders(Request $request)
    {
        $orders = Order::where('delivery_id',auth()->user()->id)->get();
        if($request->order_id){
            $order = Order::where('id',$request->order_id)->first();
            return $this->helper->ResponseJson(1, __('apis.success'), new DelOrderResource($order));

        }

        if($orders){
            return $this->helper->ResponseJson(1, __('apis.success'), DelOrderResource::collection($orders));
        }
    

        return $this->helper->ResponseJson(0, __('apis.faild'));

    }
}
