<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Provider\ProviderController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Transaction\TransactionController;
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
Route::group(['prefix' => 'buyers'], function () {
    Route::group(['middleware' => ['auth:api','buyer']], function() {
        Route::get('getAll', [BuyerController::class, 'getAll']);
        Route::get('getOne/{id}', [BuyerController::class, 'getOne']);
        Route::patch('update/{user}', [BuyerController::class, 'update']);
    });
});


Route::group(['prefix' => 'sellers'], function () {
    Route::group(['middleware' => ['auth:api','seller']], function() {
        Route::get('getAll', [SellerController::class, 'getAll']);
        Route::get('getOne/{id}', [SellerController::class, 'getOne']);
        Route::patch('update/{user}', [SellerController::class, 'update']);
        Route::post('setTransaction', [TransactionController::class, 'setTransaction']);
        Route::get('getAllTransactions', [TransactionController::class, 'getAllTransactions']);
        Route::get('getOneTransaction/{id}', [TransactionController::class, 'getOneTransaction']);
    });
});


Route::group(['prefix' => 'providers'], function () {
    Route::group(['middleware' => ['auth:api','provider']], function() {
        Route::get('getAll', [ProviderController::class, 'getAll']);
        Route::get('getOne/{id}', [ProviderController::class, 'getOne']);
        Route::patch('update/{user}', [ProviderController::class, 'update']);
        Route::post('setProduct', [ProductController::class, 'setProduct']);
        Route::get('allProductsByOwnProvider', [ProductController::class, 'allProductsByOwnProvider']);
        Route::patch('updateProduct/{product}', [ProductController::class, 'updateProduct']);
    });
});


Route::resource('users',UserController::class)->only([
    'index', 'show','update'
]);
Route::group(['prefix' => 'products'], function () {
    Route::get('allProducts', [ProductController::class, 'allProducts']);
    Route::get('allProductsByOwnProvider', [ProductController::class, 'allProductsByOwnProvider']);
    Route::get('allProductsBySpecificProvider/{provider}', [ProductController::class, 'allProductsBySpecificProvider']);
});
