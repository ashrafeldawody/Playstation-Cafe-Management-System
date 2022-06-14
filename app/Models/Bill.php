<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    protected $guarded = [];
    protected $hidden = ['user_id','device_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
    public function cafeBill()
    {
        return $this->hasOne(CafeBill::class);
    }
    public function sessions()
    {
        return $this->hasMany(PlaySession::class);
    }
    public function activeSession()
    {
        return $this->sessions()->where('end_time', null);
    }
    public function getTotalPriceAttribute()
    {
        return $this->sessions->sum('cost');
    }
}
