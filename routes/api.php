<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CorsMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\JoinGameController;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Admin\api\BrandController;
use App\Http\Controllers\Admin\api\CategoryController;
use App\Http\Controllers\Admin\api\PurchaseOrdersController;

// php artisan make:controller BrandController --resource --model=Brand --request=StoreBrandRequest


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// }); 


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', CorsMiddleware::class])->group(function () {

    Route::get('/', function () {
        $testdata = "WellCome, " . auth()->user()->name . ", Connect to API";
        return response()->json(['info' => $testdata,]);
    })->name('brand');

    Route::apiResource('brands', BrandController::class);
    Route::apiResource('categories', CategoryController::class);

    Route::apiResource('purchase-orders', PurchaseOrdersController::class);





    Route::post('join-game',  [JoinGameController::class, 'join']);
    Route::post('get-coin',  [JoinGameController::class, 'getCoin']);
    Route::post('get-win',  [JoinGameController::class, 'getWin']);
    Route::get('TopTenUser',  [JoinGameController::class, 'TopTenUser']);
});
