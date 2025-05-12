<?php

use App\Http\Controllers\AccessoryController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BikeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\JwtAuthenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::middleware(JwtAuthenticate::class)->group(function(){
    Route::get('/me', [AuthController::class, 'checkToken']);
    Route::post('/cart/add', [CartItemController::class, 'addToCart']);
    Route::post('/cart/remove', [CartItemController::class, 'removeFromCart']);
    Route::get('/cart', [CartItemController::class, 'getCartItems']);
    Route::post('/create-order', [PaymentController::class, 'createOrder']);
    Route::post('/verify-payment', [PaymentController::class, 'verifyPayment']);
    Route::post('/store-info', [PaymentController::class, 'storeInfo']);
    Route::get('/orders', [OrderController::class, 'getOrderItems']);
});
Route::post('/appointment/create', [AppointmentController::class, "createAppointment"]);
Route::get('/bikes', [BikeController::class, "getBikes"]);
Route::get('/accessories', [AccessoryController::class, "getAccessories"]);
Route::get('/bike/{slug}', [BikeController::class, "getBikeBySlug"]);
Route::get('/accessory/{slug}', [AccessoryController::class, "getAccessoryBySlug"]);
Route::get('/brands', [BrandController::class, "getBrands"]);
Route::post('/register', [AuthController::class, "register"]);
Route::post('/login', [AuthController::class, "login"]);
Route::get('/test', function(Request $request){
    $user = $request->user();
    return response()->json(['message'=>'Success', 'data'=>$user]);
})->middleware(JwtAuthenticate::class);

Route::post('/logout', [AuthController::class, "logout"]);