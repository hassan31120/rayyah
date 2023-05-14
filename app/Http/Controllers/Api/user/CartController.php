<?php

namespace App\Http\Controllers\Api\user;

use App\Models\Cart;
use App\helpers\helper;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartDetailsResource;

class CartController extends Controller
{
    public function __construct()
    {
        $this->helper = new helper();
    }
    public function createCart(Request $request){

        $validator=validator()->make($request->all(),[
            'product_id'=>'required|exists:products,id',
            'del_price'=>'required',
            'description'=>'required',
            ]);
            if($validator->fails()){
          return $this->helper->ResponseJson(0,$validator->errors()->first(),$validator->errors());
            }
            
            $product=Product::findOrFail($request->product_id);
            $checkCartItem = Cart::where('client_id',auth()->user()->id)->where('product_id',$product->id)->first();
            if($checkCartItem){
                return $this->helper->ResponseJson(0, __('apis.cart_faild'));
    
            }
            $cart=Cart::create([
                'product_id'=>$request->product_id,
                'del_price'=>$request->del_price,
                'description'=>$request->description,
                'client_id' => auth()->user()->id,
    
               ]);
               return $this->helper->ResponseJson(1, __('apis.success'), $cart);
    
    }

    public function cartDetails(Request $request)
    {
        $carts=Cart::where('client_id',auth()->user()->id)->get();

        $collectCartPrice = [];
        foreach($carts as $item)
        {
             $price = Cart::where('id',$item->id)->first();
             $collectCartPrice[] = $item->del_price;
        }
         $totalprice = array_sum($collectCartPrice);

         if($carts != '[]')
         {
             return [
                 'key' => 'succes',
                 'total'=>$totalprice,
                 'products' => CartDetailsResource::collection($carts)->map(function($row){
                     return[
                         'data' =>$row
     
                     ];
                 })->values()->all()
             ];
         }else {
                 return [
                     'msg' => __('apis.cart_is_empty'),
                     'key' => 'empty',
                     'data' => [],
                 ];
             }
    }

    public function removeFromCart(Request $request)
    {
        
        if ($request->type == 'single') {
            $carts = Cart::where('product_id',$request->product_id)->first();
            if($carts){
                
            $carts->delete();
            return $this->helper->responseJson(1, __('apis.cart_delete'));
            }
                        return $this->helper->responseJson(1, __('apis.already_rem'));

        } else {
            $carts = Cart::where('client_id', auth()->user()->id)
                ->get()->each->delete();

            return $this->helper->responseJson(1, __('apis.removeAll'));
        }
    }

    }
