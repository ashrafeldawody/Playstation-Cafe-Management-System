<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CafeBillItem extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    protected $guarded = [];
    function bill()
    {
        return $this->belongsTo(Bill::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::created(function ($item) {
            Inventory::create([
                'item_id' => $item->item_id,
                'quantity' => -$item->quantity,
                'type' => 'SELL',
                'user_id' => $item->bill->user_id,
            ]);
        });
        static::deleted(function ($item) {
            Inventory::create([
                'item_id' => $item->item_id,
                'quantity' => $item->quantity,
                'type' => 'RETURN',
                'user_id' => $item->bill->user_id,
            ]);
        });
    }

}
