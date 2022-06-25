<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $guarded = [];
    function category(){
        return $this->belongsTo(devicesCategory::class,'devices_category_id');
    }
    function activeBill()
    {
        return $this->hasOne(Bill::class)->whereHas('sessions', function ($query) {
            $query->where('end_time', null);
        });
    }
}
