<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('bill', 'BillCrudController');
    Route::crud('cafe-bill', 'CafeBillCrudController');
    Route::crud('cafe-bill-item', 'CafeBillItemCrudController');
    Route::crud('device', 'DeviceCrudController');
    Route::crud('inventory', 'InventoryCrudController');
    Route::crud('item', 'ItemCrudController');
    Route::crud('devices-category', 'DevicesCategoryCrudController');
    Route::crud('items-category', 'ItemsCategoryCrudController');
    Route::crud('play-session', 'PlaySessionCrudController');
}); // this should be the absolute last line of this file
