<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\DetailTransaction\DetailTransactionController;
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
        Route::patch('updateBuyer/{user}', [BuyerController::class, 'update']);
    });
});

Route::group(['prefix' => 'sellers'], function () {
    Route::group(['middleware' => ['auth:api','seller']], function() {
        Route::get('getAllBuyers', [BuyerController::class, 'getAll']);
        Route::get('getOneBuyer/{id}', [BuyerController::class, 'getOne']);
        Route::patch('updateBuyer/{user}', [BuyerController::class, 'update']);

        Route::get('getAllProviders', [ProviderController::class, 'getAll']);
        Route::get('getOneProvider/{id}', [ProviderController::class, 'getOne']);
        Route::patch('updateProvider/{user}', [ProviderController::class, 'update']);

        Route::get('allProducts', [ProductController::class, 'allProducts']);
        Route::get('allProductsBySpecificProvider/{provider}', [ProductController::class, 'allProductsBySpecificProvider']);

        Route::get('getAllSellers', [SellerController::class, 'getAll']);
        Route::get('getOneSeller/{id}', [SellerController::class, 'getOne']);
        Route::patch('updateSeller/{user}', [SellerController::class, 'update']);
        Route::post('setTransaction', [TransactionController::class, 'setTransaction']);
        Route::get('getAllTransactions', [TransactionController::class, 'getAllTransactions']);
        Route::get('getOneTransaction/{id}', [TransactionController::class, 'getOneTransaction']);
        Route::get('getDetailOfTransaction/{id}', [DetailTransactionController::class, 'getDetailOfTransaction']);

    });
});


Route::group(['prefix' => 'providers'], function () {
    Route::group(['middleware' => ['auth:api','provider']], function() {
        Route::patch('updateProvider/{user}', [ProviderController::class, 'update']);
        Route::post('setProduct', [ProductController::class, 'setProduct']);
        Route::get('allProductsByOwnProvider', [ProductController::class, 'allProductsByOwnProvider']);
        Route::patch('updateProduct/{product}', [ProductController::class, 'updateProduct']);
    });
});


// Route::resource('users',UserController::class)->only([
//     'index', 'show','update'
// ]);
// Route::group(['prefix' => 'products'], function () {
//     Route::get('allProducts', [ProductController::class, 'allProducts']);
//     Route::get('allProductsByOwnProvider', [ProductController::class, 'allProductsByOwnProvider']);
// });
