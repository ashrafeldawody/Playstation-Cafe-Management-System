<?php

use App\Http\Controllers\Cashier\DevicesController;
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
Route::group(['prefix' => 'play'], function () {
    Route::resource('/devices', 'DeviceController');
    Route::post('/start', DevicesController::class . '@start');
    Route::post('/finish/{device_id}',  DevicesController::class . '@finish');
    Route::post('/toggle_multi/{device_id}',  DevicesController::class . '@toggleMulti');
    Route::post('/change_limit/{device_id}/{time_limit}',  DevicesController::class . '@changeLimit');
    Route::post('/update_cart/{bill_id}',  DevicesController::class . '@updateCart');
});
