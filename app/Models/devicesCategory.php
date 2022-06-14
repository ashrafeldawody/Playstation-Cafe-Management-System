<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class devicesCategory extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;

    protected $guarded = [];
     function devices(){
        return $this->hasMany(Device::class);
    }
}
