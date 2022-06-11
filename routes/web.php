<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('auth/login', [\Turnover\Auth\LoginController::class, 'login']);
Route::post('auth/logout', [\Turnover\Auth\LoginController::class, 'logout'])->middleware('auth:sanctum');
