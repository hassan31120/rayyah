<?php

namespace App\Http\Controllers\Api\user;

use App\Models\Order;
use App\Models\Banner;
use App\Models\Wallet;
use App\helpers\helper;
use App\Models\Address;
use App\Models\Product;
use App\Models\Service;
use App\Models\Category;
use App\Models\OrderOffer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PlaceResource;
use App\Http\Resources\TransResource;
use App\Http\Resources\BannerResource;
use App\Http\Resources\OffersResource;
use App\Http\Resources\HomeCatResource;
use App\Http\Resources\DelOrderResource;
use App\Http\Resources\PlaceByCatResource;
use App\Http\Resources\TrackOrderResource;

class UserController extends Controller
{
    public function __construct()
    {
        $this->helper = new helper();
    }
    private function toGetPlace($latitude, $longitude)
    {



        $places = new Product();

        $places = $places->select("*", DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                                * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $longitude . "))
                                + sin(radians(" . $latitude . ")) * sin(radians(latitude))) AS distance"));
        $places = $places->having('distance', '<', 50);
        $places = $places->orderBy('distance', 'asc');

        $places = $places->with('attachmentRelation');
        return $places;
    }
    public function home(Request $request)
    {
        $services = HomeCatResource::collection(Service::all());
        $banners = Banner::select('id', 'banner_' . app()->getLocale() . ' as banner', 'created_at')->get();

        if ($request->service_id) {
            $service = Service::where('id', $request->service_id)->first();
            if ($service) {
                return $this->helper->ResponseJson(1, __('apis.success'), new PlaceResource($service));
            } else {
                return $this->helper->ResponseJson(0, __('apis.faild'), null);
            }
        }

        if ($services) {
            return $this->helper->ResponseJson(1, __('apis.success'), [
                'services' => PlaceResource::collection($services),
                'Banners' => BannerResource::collection($banners)
            ]);
        }
        return $this->helper->ResponseJson(0, __('apis.faild'));
    }

    public function Category(Request $request)
    {
        if ($request->address_id) {
            $address = Address::findOrFail($request->address_id);
            $latitude = $address->lat;
            $longitude = $address->long;
        } else {
            $latitude = auth()->user()->lat;
            $longitude = auth()->user()->lng;
        }

        $places = $this->toGetPlace($latitude, $longitude)->where('category_id', $request->category_id)->get();

        return $this->helper->ResponseJson(1, __('apis.success'), PlaceByCatResource::collection($places));
    }

    public function myOrders(Request $request)
    {
        $orders = Order::where('client_id', auth()->user()->id)->get();
        if ($request->order_id) {
            $order = Order::where('id', $request->order_id)->first();
            if ($order) {
                return $this->helper->ResponseJson(1, __('apis.success'), new TrackOrderResource($order));
            }
            return $this->helper->ResponseJson(0, __('apis.faild'));
        }
        return $this->helper->ResponseJson(1, __('apis.success'), OrderResource::collection($orders));
    }
    public function myTrans(Request $request)
    {
        $wallet = Wallet::where('client_id', auth()->user()->id)->first();

        return $this->helper->ResponseJson(1, __('apis.success'), new TransResource($wallet));
    }

    function search(Request $request)
    {


        $result = Service::where('name', 'LIKE', '%' . $request->name . '%')->get();
        if (count($result)) {
            return $this->helper->ResponseJson(1, __('apis.success'), PlaceResource::collection($result));
        } else {
            return response()->json(['Result' => 'No Data not found'], 404);
        }
    }

    public function cancelOrder(Request $request)
    {
        $validate = $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);
        $order = Order::findOrFail($validate['order_id']);
        if ($order->status == 'pending') {
            $order->status = 'cancelled';
            $order->save();
            return $this->helper->ResponseJson(1, __('apis.success'));
        }
        return $this->helper->ResponseJson(0, __('apis.order_faild'));
    }


    public function listOffers(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $offers = OrderOffer::where('client_id', auth()->user()->id)->where('order_id', $order->id)->where('status', 'pending')->get();
        if ($offers) {
            return $this->helper->ResponseJson(1, __('apis.success'), OffersResource::collection($offers));
        }
        return $this->helper->ResponseJson(0, __('apis.faild'));
    }

    public function acceptOffer(Request $request)
    {
        $validate = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'offer_id' => 'required|exists:offer_order,id',
        ]);
        $order = Order::findOrFail($request->order_id);
        if ($order) {
            $offer = OrderOffer::find($request->offer_id);
            $offer->update([
                'status' => 'accepted',
            ]);

            $offers = OrderOffer::where('order_id', $order->id)->get()->except($offer->id);
            //send noti to accepted offer delivery
            notify(__('notification.offer_accepted_title'), __('notification.offer_accepted_body'), [$offer->delivery]);

            foreach ($offers as $offer) {
                $offer->update([
                    'status' => 'rejected',
                ]);
                //send noti to each  offer rejected delivery
                notify(__('notification.offer_rejected_title'), __('notification.offer_rejected_body'), [$offer->delivery]);
            }
            $order->update([
                'delivery_id' => $offer->delivery_id,
                'est_time' => $offer->est_time ?? null,
                'total_del_price' => $offer->price,
                'status' => 'on_delivery'
            ]);
            return $this->helper->ResponseJson(1, __('apis.success'), new OffersResource($offer));
        }

        return $this->helper->ResponseJson(1, __('apis.faild'));
    }
}
