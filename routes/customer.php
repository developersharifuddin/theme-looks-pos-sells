<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CustomerController;

Route::get('customer/register', [CustomerController::class, 'index'])->name('home');
