<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceCategory extends Model
{
    protected $table = 'devices_categories';
    protected $guarded = [];
     function devices(){
        return $this->hasMany(Device::class);
    }
}
