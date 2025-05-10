<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\JwtAuthenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::middleware(JwtAuthenticate::class)->group(function(){
    Route::get('/me', [AuthController::class, 'checkToken']);
   
});
Route::post('/register', [AuthController::class, "register"]);
Route::post('/login', [AuthController::class, "login"]);
Route::get('/test', function(Request $request){
    $user = $request->user();
    return response()->json(['message'=>'Success', 'data'=>$user]);
})->middleware(JwtAuthenticate::class);

Route::post('/logout', [AuthController::class, "logout"]);