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
    protected $appends = ['duration','overtime','overtimePrice'];
    public function bills()
    {
        return $this->hasMany(Bill::class);
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
}
