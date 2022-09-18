<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $guarded = [];
    protected $hidden = ['user_id', 'device_id'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function device(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function sessions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PlaySession::class);
    }

    public function activeSession(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->sessions()->where('end_time', null);
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CafeBillItem::class);
    }

    public function tempItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TempBillItem::class);
    }

    public static function stats($start_time = null, $end_time = null)
    {
        if ($start_time && $end_time) {
            $bills = Bill::with('items')->whereBetween('created_at', [$start_time, $end_time])->get();
        } else {
            $bills = Bill::with('items')->get();
        }

        return [
            ['title' => 'عدد الفواتير', 'value' => $bills->count(), 'icon' => 'fa fa-file-invoice-dollar', 'bg-color' => 'bg-primary',],
            ['title' => 'اجمالي اللعب', 'value' => $bills->sum('play_total'), 'icon' => 'fa fa-play', 'bg-color' => 'bg-success',],
            ['title' => 'اجمالي الكافيه', 'value' => $bills->sum('cafe_total'), 'icon' => 'fa fa-coffee', 'bg-color' => 'bg-warning',],
            ['title' => 'اجمالي المدفوع', 'value' => $bills->sum('paid'), 'icon' => 'fa fa-money-bill', 'bg-color' => 'bg-danger',],
            [
                'title' => 'مكسب الكافيه',
                'value' => $bills->sum(function ($bill) {return $bill->items->sum(function ($item) {return $item->item->revenue * $item->quantity;});}),
                'icon' => 'fa fa-money-bill',
                'bg-color' => 'bg-danger',
                ],
        ];
    }

}
