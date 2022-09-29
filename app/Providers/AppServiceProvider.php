<?php

namespace App\Providers;

use App\Http\Resources\BillResource;
use App\Http\Resources\CashierDeviceResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\BillItemResource;
use App\Http\Resources\SessionResource;
use App\Models\setting;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();
        view()->composer('*', function ($view) {
            $currency = setting::where('key', 'currency')->first()->value;
            $view->with('currency', $currency);
        });
    }
}
