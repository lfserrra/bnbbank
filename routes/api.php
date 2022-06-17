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
    Route::get('customer/balance', [\Turnover\Customer\CustomerController::class, 'balance']);

    Route::get('transactions', [\Turnover\Transaction\TransactionController::class, 'index']);
    Route::get('transactions', [\Turnover\Transaction\TransactionController::class, 'index']);
    Route::get('transactions/{transaction_id}', [\Turnover\Transaction\TransactionController::class, 'show']);
    Route::get('transactions/{transaction_id}/image', [\Turnover\Transaction\TransactionController::class, 'image']);

    Route::post('deposit/{transaction_id}/accept', [\Turnover\ManageDeposit\ManageDepositController::class, 'accept']);
    Route::post('deposit/{transaction_id}/reject', [\Turnover\ManageDeposit\ManageDepositController::class, 'reject']);

    Route::post('deposit', [\Turnover\Deposit\DepositController::class, 'store']);
    Route::post('purchases', [\Turnover\Purchase\PurchaseController::class, 'store']);
});
