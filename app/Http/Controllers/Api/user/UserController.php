<?php

namespace App\Http\Controllers\Api\user;

use App\Models\Order;
use App\Models\Wallet;
use App\helpers\helper;
use App\Models\Address;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PlaceResource;
use App\Http\Resources\TransResource;
use App\Http\Resources\HomeCatResource;
use App\Http\Resources\PlaceByCatResource;
use App\Http\Resources\TrackOrderResource;

class UserController extends Controller
{ 
    public function __construct()
    {
        $this->helper = new helper();
    }
     private  function toGetPlace($latitude,$longitude)
    {



        $places          =       new Product() ;

        $places          =       $places->select("*", DB::raw("6371 * acos(cos(radians("                                         . $latitude . "))
                                * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $longitude . "))
                                + sin(radians(" .$latitude. ")) * sin(radians(latitude))) AS distance"));
        $places          =       $places->having('distance', '<', 50);
        $places          =       $places->orderBy('distance', 'asc');

        $places          =       $places->with('attachmentRelation');


        return $places ;
    }

    
    public function home(Request $request)
    {
        $cats = HomeCatResource::collection(Category::all());
        
        if($request->address_id){
            $address = Address::findOrFail($request->address_id);
            $latitude       =       $address->lat;
            $longitude      =       $address->long;
        }else{
            $latitude       =       auth()->user()->lat;
            $longitude      =       auth()->user()->lng;
    
        }

        $places =  $this->toGetPlace($latitude,$longitude)->get(); 
        if($request->place_id){
            
            $places =  $this->toGetPlace($latitude,$longitude)->where('id',$request->place_id)->first(); 
            if($places){
                return $this->helper->ResponseJson(1, __('apis.success'),  new PlaceResource($places));

            }
            return $this->helper->ResponseJson(0, __('apis.faild'));


        }
        
        return $this->helper->ResponseJson(1, __('apis.success'), ['cats'=>$cats , 'places'=> PlaceResource::collection($places)]);


    }

    public function Category(Request $request)
    {
        if($request->address_id){
            $address = Address::findOrFail($request->address_id);
            $latitude       =       $address->lat;
            $longitude      =       $address->long;
        }else{
            $latitude       =       auth()->user()->lat;
            $longitude      =       auth()->user()->lng;
    
        }
        
        $places =  $this->toGetPlace($latitude,$longitude)->where('category_id',$request->category_id)->get(); 

        return $this->helper->ResponseJson(1, __('apis.success'), PlaceByCatResource::collection($places));

    }

    public function myOrders(Request $request){
        $orders = Order::where('client_id',auth()->user()->id)->get();
        if($request->order_id){
            $order = Order::where('id',$request->order_id)->first();
            if($order){
                return $this->helper->ResponseJson(1, __('apis.success'), new TrackOrderResource($order));

            }
            return $this->helper->ResponseJson(0, __('apis.faild'));
        }
        return $this->helper->ResponseJson(1, __('apis.success'), OrderResource::collection($orders));


    }
    public function myTrans(Request $request)
    {
        $wallet = Wallet::where('user_id', auth()->user()->id)->first();

        
            return $this->helper->ResponseJson(1, __('apis.success'), new TransResource($wallet));


    }

    function search(Request $request)
    {

        if($request->address_id){
            $address = Address::findOrFail($request->address_id);
            $latitude       =       $address->lat;
            $longitude      =       $address->long;
        }else{
            $latitude       =       auth()->user()->lat;
            $longitude      =       auth()->user()->lng;
    
        }
        $result = $this->toGetPlace($latitude,$longitude)->where('name', 'LIKE', '%'. $request->name. '%')->get();
           if(count($result)){
                return $this->helper->ResponseJson(1, __('apis.success'), PlaceByCatResource::collection($result));
            }
            else
            {
            return response()->json(['Result' => 'No Data not found'], 404);
          }


    }
}
