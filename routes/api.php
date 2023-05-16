<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\ComplainsController;
use App\Http\Controllers\Api\user\CartController;
use App\Http\Controllers\Api\user\UserController;
use App\Http\Controllers\Api\user\OrderController;
use App\Http\Controllers\Api\user\WalletController;
use App\Http\Controllers\Api\user\AddressController;
use App\Http\Controllers\Api\user\DeliveryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'api-lang'], function () {
    Route::group(['middleware' => 'auth:api'], function () {

        Route::post('/add-cart', [CartController::class,'createCart']);
        Route::post('/cart-details', [CartController::class,'cartDetails']);
        Route::post('delete-item-cart', [CartController::class,'removeFromCart']);
        Route::post('place-order', [OrderController::class,'placeOrder']);
        Route::get('home',[UserController::Class , 'home']);
        Route::post('category',[UserController::Class , 'category']);

        Route::get('/user_addresses', [AddressController::class, 'index']);
        Route::post('/add_address', [AddressController::class, 'store']);
        Route::post('/edit_address/{id}', [AddressController::class, 'update']);
        Route::post('/del_address/{id}', [AddressController::class, 'destroy']);

        Route::get('my-orders',[UserController::class,'myOrders']);
        Route::post('deposit',[WalletController::class , 'deposit']);
        Route::post('withdraw',[WalletController::class , 'withdraw']);
        Route::post('sendBalane',[WalletController::class , 'sendBalane']);
        Route::get('my-trans',[UserController::class,'myTrans']);
        Route::post('search',[UserController::class,'search']);
        Route::post('cancel-order',[UserController::class,'cancelOrder']);

        Route::post('/insertData', [AuthController::class, 'insertData']);
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/editProfile', [AuthController::class, 'editProfile']);
        Route::post('/delUser', [AuthController::class, 'delUser']);


        Route::prefix('delivery')->group(function(){
            Route::post('list-orders',[DeliveryController::class,'listOrders']);
            Route::post('accept-order',[DeliveryController::class,'acceptOrder']);
            Route::post('finish-order',[DeliveryController::class,'finishOrder']);
            Route::post('my-orders',[DeliveryController::class,'myOrders']);

        });

    }) ;
            
    });
    Route::get('/settings', [SettingController::class, 'index']);



    Route::post('/auth', [AuthController::class, 'auth']);
    Route::post('/verify', [AuthController::class, 'verify']);

    Route::post('/send_complain', [ComplainsController::class, 'send_complain']);
    Route::post('/contact_us', [ComplainsController::class, 'contact_us']);
});
