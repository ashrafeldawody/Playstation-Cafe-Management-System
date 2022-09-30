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
use App\Http\Controllers\Dashboard\SalaryController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\ShiftController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\POS\CartController;
use App\Http\Controllers\POS\PlayController;
use App\Http\Controllers\POS\ShopController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Auth::routes();

Route::get('/', function () {
    if(!Auth::check())
        return redirect()->route('pos.index');
    elseif (Auth::user()->hasRole('admin'))
        return redirect()->route('dashboard');
    else
        return redirect()->route('pos.index');

});
// create dashboard group routes
Route::group(['middleware' => ['auth','role:user'],'prefix'=>'pos','as' => 'pos.'], function () {
    Route::get('/shift', [\App\Http\Controllers\POS\ShiftController::class, 'index'])->name('shift.index');
    Route::post('/shift/start', [\App\Http\Controllers\POS\ShiftController::class, 'start'])->name('shift.start');
    Route::post('/shift/end', [\App\Http\Controllers\POS\ShiftController::class, 'end'])->name('shift.end');
    Route::group(['middleware' => ['hasShift']], function () {
        Route::get('/', [PlayController::class,'index'])->name('index');
        Route::get('/cafe', [CartController::class,'index'])->name('cafe.index');
        Route::get('/stats', [\App\Http\Controllers\POS\ShiftController::class, 'stats'])->name('shift.stats');
        Route::get('/monthly-shifts', [\App\Http\Controllers\POS\ShiftController::class, 'monthlyShifts'])->name('shift.monthly');

        Route::get('/cafe-items', [\App\Http\Controllers\POS\CafeController::class, 'index'])->name('cafe.items');
        Route::get('/expenses', [\App\Http\Controllers\POS\ExpenseController::class, 'index'])->name('expense.index');
        Route::get('/account', [\App\Http\Controllers\POS\AccountController::class, 'index'])->name('account.index');
    });
});

Route::group(['middleware' => ['auth','role:admin'],'prefix'=>'dashboard'], function () {
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

    Route::resource('/expenses', ExpenseController::class)->names('expenses');

    Route::resource('/bills', BillController::class)->names('bills');

    Route::resource('/inventory', InventoryController::class)->names('inventory');

    Route::get('/reports', [ReportController::class,'index'])->name('reports.index');

    Route::resource('/settings', SettingController::class)->names('settings');

    Route::resource('/users', UserController::class)->names('users');

    Route::resource('/salary', SalaryController::class)->names('salaries');
});

