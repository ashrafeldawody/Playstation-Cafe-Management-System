<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class devicesCategory extends Model
{

    protected $guarded = [];
     function devices(){
        return $this->hasMany(Device::class);
    }
}
