<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    protected $guarded = [];
    protected $hidden = ['user_id','device_id'];
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
    public function getPriceAttribute()
    {
        return $this->items->sum(function ($row) {
            return $row->price * $row->quantity;
        });
    }

}
