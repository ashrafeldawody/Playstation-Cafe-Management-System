<?php

use App\Http\Controllers\Cashier\BillController;
use App\Http\Controllers\Cashier\CafeController;
use App\Http\Controllers\Cashier\DevicesController;
use App\Http\Controllers\Cashier\ExpensesController;
use App\Http\Controllers\Cashier\ShiftController;
use App\Http\Controllers\Cashier\StatsController;
use App\Http\Controllers\POS\PlayController;
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
    Route::get('/devices', [DevicesController::class , 'index']);
    Route::get('/devices/available', [DevicesController::class , 'get_available_devices']);
    Route::post('/start', [DevicesController::class , 'start']);
    Route::post('/finish',  [DevicesController::class , 'finish']);
    Route::post('/toggle_multi/{device_id}',  [DevicesController::class , 'toggleMulti']);
    Route::post('/change_limit/{device_id}/{time_limit}',  [DevicesController::class , 'changeLimit']);
    Route::post('/update_cart/{bill_id}',  [DevicesController::class , 'updateCart']);
    Route::delete('/delete_bill/{id}', [DevicesController::class,'delete_bill'])->name('play.delete_bill');

});

Route::group(['prefix' => 'cafe'], function () {
    Route::get('/items', [CafeController::class , 'index']);
    Route::get('/list', [CafeController::class , 'list']);
    Route::post('/inventory', [CafeController::class, 'addInventoryItem']);
    Route::get('/inventory', [CafeController::class, 'getInventory']);
    Route::post('/save', [CafeController::class , 'save']);
});
Route::group(['prefix' => 'shift'], function () {
        Route::get('/check', [ShiftController::class , 'check']);
        Route::post('/start', [ShiftController::class , 'start']);
        Route::post('/end', [ShiftController::class , 'end']);
});
Route::group(['prefix' => 'bill'], function () {
        Route::get('', [BillController::class , 'index']);
        Route::post('swap', [BillController::class , 'swap']);
});
Route::group(['prefix' => 'expense'], function () {
        Route::get('', [ExpensesController::class, 'index']);
        Route::post('', [ExpensesController::class, 'store']);
});

Route::group(['prefix' => 'stats'], function () {
        Route::get('', [StatsController::class, 'index']);
        Route::get('/overtime', [StatsController::class, 'overtime']);
});

