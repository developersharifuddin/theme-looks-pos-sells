<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ItemInfoController;
use App\Http\Controllers\Admin\ServiceSellController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/', [AdminController::class, 'dashboard']);
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('/products', ItemInfoController::class);
    Route::get('/products/set-price/{id}', [ItemInfoController::class, 'findSetPrice'])->name('setPrice');
    Route::post('/products/set-price-declear', [ItemInfoController::class, 'setPrice'])->name('setPriceDeclear');
    Route::post('/newsales/getItemByBarcodeService', [ServiceSellController::class, 'getItem'])->name('newsaleitemService');

    Route::resource('/sales', ServiceSellController::class);

    Route::get('/loadProduct', [ItemInfoController::class, 'loadProduct'])->name('loadProduct');

    Route::get('/get-Product/{productId}', [ItemInfoController::class, 'getProduct']);


    Route::resource('admins', AdminsController::class);
    // Logout route
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
