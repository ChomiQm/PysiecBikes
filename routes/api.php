<?php

use App\Http\Controllers\Bike\BikeController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\OrderItem\OrderItemController;
use App\Http\Controllers\UserData\UserDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
