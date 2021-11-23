<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Provider\ProviderController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\User\UserController;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login',  [AuthController::class, 'login']);
    Route::post('signupAdmin',  [AuthController::class, 'signupAdmin']);
    Route::post('signupBuyer',  [AuthController::class, 'signupBuyer']);
    Route::post('signupSeller',  [AuthController::class, 'signupSeller']);
    Route::post('signupProvider',  [AuthController::class, 'signupProvider']);

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user',  [AuthController::class, 'user']);
    });
});


Route::resource('users',UserController::class)->only([
    'index', 'show'
]);

Route::resource('buyers',BuyerController::class)->only([
    'index', 'show'
]);

Route::resource('sellers',SellerController::class)->only([
    'index', 'show'
]);

Route::resource('providers',ProviderController::class)->only([
    'index', 'show'
]);
