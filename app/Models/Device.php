<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $guarded = [];

    public function games()
    {
        return $this->belongsToMany(Game::class,'device_has_games');
    }

    function category(){
        return $this->belongsTo(DeviceCategory::class,'devices_category_id');
    }
    function activeBill()
    {
        return $this->hasOne(Bill::class)->whereHas('sessions', function ($query) {
            $query->where('end_time', null);
        });
    }
    public static function top5($start_time=null,$end_time=null){
        $top5 = Bill::with('device')->selectRaw('device_id, count(*) as total')
            ->whereNotNull('device_id')
            ->groupBy('device_id')
            ->orderBy('total', 'desc')
            ->limit(5);
        if($start_time && $end_time){
            $top5->whereBetween('created_at', [$start_time, $end_time]);
        }
        return $top5->get();
    }
}
