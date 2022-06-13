<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('transactions', [\Turnover\Models\Transaction\TransactionController::class, 'index']);
    Route::get('transactions/{transactions_id}', [\Turnover\Models\Transaction\TransactionController::class, 'show']);

    Route::post('deposit', [\Turnover\Deposit\DepositController::class, 'store']);
    Route::post('purchases', [\Turnover\Purchase\PurchaseController::class, 'store']);
});
