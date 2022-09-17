<?php

use App\Http\Controllers\Dashboard\BillController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DeviceCategoryController;
use App\Http\Controllers\Dashboard\DeviceController;
use App\Http\Controllers\Dashboard\ExpenseController;
use App\Http\Controllers\Dashboard\InventoryController;
use App\Http\Controllers\Dashboard\ItemCategoryController;
use App\Http\Controllers\Dashboard\ItemController;
use App\Http\Controllers\Dashboard\ReportController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\ShiftController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Auth::routes();

Route::get('/', function () {
    return redirect()->route('dashboard');
});
// create dashboard group routes
Route::group(['middleware' => 'auth','prefix'=>'dashboard'], function () {
    Route::get('/', [DashboardController::class,'index'])->name('dashboard');

    Route::get('/shifts', [ShiftController::class,'index'])->name('shifts');

    Route::resource('/devices', DeviceController::class)->names('devices');
    Route::get('/devices/{id}/delete', [DeviceController::class,'delete'])->name('devices.delete');

    Route::resource('/items', ItemController::class)->names('items');
    Route::get('/items/{id}/delete', [ItemController::class,'delete'])->name('items.delete');

    Route::resource('/device-categories', DeviceCategoryController::class)->names('device-categories');
    Route::get('/device-categories/{id}', [DeviceCategoryController::class,'delete'])->name('device-categories.delete');

    Route::resource('/item-categories', ItemCategoryController::class)->names('item-categories');
    Route::get('/item-categories/{id}', [ItemCategoryController::class,'delete'])->name('item-categories.delete');

    Route::get('/expenses', [ExpenseController::class,'index'])->name('expenses.index');

    Route::resource('/bills', BillController::class)->names('bills');

    Route::resource('/inventory', InventoryController::class)->names('inventory');

    Route::get('/reports', [ReportController::class,'index'])->name('reports.index');
    Route::get('/reports/daily', [ReportController::class,'daily'])->name('reports.daily');
    Route::get('/reports/monthly', [ReportController::class,'monthly'])->name('reports.monthly');
    Route::get('/reports/yearly', [ReportController::class,'yearly'])->name('reports.yearly');

    Route::resource('/settings', SettingController::class)->names('settings');

    Route::resource('/users', UserController::class)->names('users');


});

