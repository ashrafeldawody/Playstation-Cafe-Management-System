<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $appends = ['duration','overtime','overtimePrice','total_paid','total_discount','cafe_total','play_total'];
    public function bills()
    {
        return $this->hasMany(Bill::class)->with('sessions', 'items', 'device', 'device.category')
            ->whereDoesntHave('activeSession')
            ->orderBy('updated_at', 'desc');
    }
    public function items()
    {
        return $this->hasManyThrough(CafeBillItem::class, Bill::class);
    }
    public function sessions()
    {
        return $this->hasManyThrough(PlaySession::class, Bill::class);
    }
    public function getDurationAttribute()
    {
        return Carbon::parse($this->start_time)->diffInMinutes(Carbon::parse($this->end_time));
    }
    public function getOvertimeAttribute()
    {
        return $this->duration - (8*60);
    }
    public function getOvertimePriceAttribute()
    {
        return round(($this->overtime/60) * env('OVERTIME_PRICE',10));
    }

    public function getCafeTotalAttribute()
    {
        return $this->bills->sum('cafe_total');
    }
    public function getPlayTotalAttribute()
    {
        return $this->bills->sum('play_total');
    }
    public function getTotalDiscountAttribute()
    {
        return $this->bills->sum('discount');
    }
    public function getTotalPaidAttribute()
    {
        return $this->bills->sum('paid');
    }

    public function stats()
    {
        return Bill::stats($this->bills);
    }

}
