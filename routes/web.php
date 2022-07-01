<?php

use Illuminate\Support\Facades\Auth;
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


Auth::routes();

// create dashboard group routes
Route::group(['middleware' => 'auth','prefix'=>'dashboard'], function () {
    Route::get('/shifts', [\App\Http\Controllers\Dashboard\ShiftController::class,'index'])->name('shifts');

});
