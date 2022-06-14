<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CafeBill extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    protected $guarded = [];
    protected $appends = ['price'];
    protected $hidden = ['created_at','updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
    public function items()
    {
        return $this->hasMany(CafeBillItem::class);
    }

    public function getPriceAttribute()
    {
        return $this->items->sum(function ($row) {
            return $row->price * $row->quantity;
        });
    }
}
