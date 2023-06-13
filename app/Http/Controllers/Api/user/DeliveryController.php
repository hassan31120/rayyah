<?php

namespace App\Http\Controllers\Api\user;

use App\Models\User;
use App\Models\Order;
use App\Models\Client;
use App\helpers\helper;
use App\Models\OrderOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\OrderDeliver;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;
use App\Notifications\OrderAcceptNoti;
use App\Http\Resources\DelOrderResource;
use App\Http\Resources\OffersResource;
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
        $orders = Order::where('status', 'pending')->get();

        if ($request->order_id) {
            $order = Order::where('id', $request->order_id)->where('status', 'pending')->first();
            if ($order) {
                return $this->helper->ResponseJson(1, __('apis.success'), new TrackOrderResource($order));
            }
            return $this->helper->ResponseJson(0, __('apis.faild'));
        }

        return $this->helper->ResponseJson(1, __('apis.success'), TrackOrderResource::collection($orders));
    }

    public function myOffers()
    {
        $offers = OrderOffer::where('delivery_id', auth('sanctum')->user()->id)->where('status', 'pending')->get();
        return $this->helper->ResponseJson(1, __('apis.success'), OffersResource::collection($offers));
    }

    public function acceptOrder(Request $request)
    {
        $validate = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'total_service_price' => 'required'
        ]);
        $order = Order::where('id', $validate['order_id'])->first();
        if ($order) {
            $order->status = 'on_delivery';
            $order->total_service_price = $validate['total_service_price'];
            $order->total_cost = $validate['total_service_price'] + $order->total_del_price;
            $order->delivery_id = auth()->user()->id;
            $order->save();
            $users = User::where('id', 1)->first();
            $user_create = Auth::user()->name;
            Notification::send($users, new OrderAcceptNoti($order->id, $user_create));
            $client = Client::find($order->client_id);
            notify(
                __('notification.accepted'),
                __('notification.accepted_by', ['delivery' => $order->delivery->name, 'number' => $order->delivery->number]),
                [$client]
            );
            return $this->helper->ResponseJson(1, __('apis.success'), new TrackOrderResource($order));
        }
        return $this->helper->ResponseJson(0, __('apis.faild'));
    }

    public function finishOrder(Request $request)
    {
        $validate = $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);
        $order = Order::where('delivery_id', auth()->user()->id)->where('id', $validate['order_id'])->first();
        if ($order) {
            $order->status = 'done';
            $order->save();
            $users = User::where('id', 1)->first();
            $user_create = Auth::user()->name;
            Notification::send($users, new OrderDeliver($order->id, $user_create));

            $client = Client::find($order->client_id);
            notify(
                __('notification.finished'),
                __('notification.finished_by', ['delivery' => $order->delivery->name, 'number' => $order->delivery->number]),
                [$client]
            );

            return $this->helper->ResponseJson(1, __('apis.success'));
        }
        return $this->helper->ResponseJson(0, __('apis.faild'));
    }

    public function myOrders(Request $request)
    {

        $orders = Order::with('delivery')->where('delivery_id', auth()->user()->id)->get();
        if ($request->order_id) {
            $order = Order::where('id', $request->order_id)->first();
            return $this->helper->ResponseJson(1, __('apis.success'), new TrackOrderResource($order));
        }

        if ($orders) {
            return $this->helper->ResponseJson(1, __('apis.success'), TrackOrderResource::collection($orders));
        }


        return $this->helper->ResponseJson(0, __('apis.faild'));
    }

    public function makeOffer(Request $request)
    {
        $validate = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'price' => 'required|int',
        ]);

        $order = Order::findOrFail($validate['order_id']);
        if ($order) {
            $offer = new OrderOffer();
            $offer->order_id = $order->id;
            $offer->client_id = $order->client_id;
            $offer->est_time = $request->est_time;
            $offer->delivery_id = auth()->user()->id;
            $offer->price = $validate['price'];

            $offer->save();

            DB::commit(); // Commit the transaction since all operations were successful

            return $this->helper->ResponseJson(1, __('apis.success'), $offer);
        } else {

            return $this->helper->ResponseJson(1, __('apis.faild'), []);
        }
    }

    public function CancelOffer(Request $request)
    {
        $request->validate([
            'offer_id' => 'required',
        ]);
        $offer = OrderOffer::find($request->offer_id);
        if ($offer) {
            if ($offer->delivery_id != auth('sanctum')->user()->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'this is not your offer to cancel!'
                ]);
            }
            $offer->delete();
            return response()->json([
                'success' => true,
                'message' => 'Cancled!'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'there is no offer to Cancel!'
        ]);
    }
}
