<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CafeBillItem extends Model
{
    protected $guarded = [];
    protected $appends = ['item_name'];
    function bill()
    {
        return $this->belongsTo(Bill::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::created(function ($item) {
            Inventory::create([
                'bill_id' => $item->bill_id,
                'item_id' => $item->item_id,
                'quantity' => -$item->quantity,
                'type' => 'SELL',
            ]);
        });
        static::updated(function ($item) {
            Inventory::create([
                'bill_id' => $item->bill_id,
                'item_id' => $item->item_id,
                'quantity' => -$item->quantity,
                'type' => 'SELL',
            ]);
        });
        static::deleted(function ($item) {
            Inventory::create([
                'bill_id' => $item->bill_id,
                'item_id' => $item->item_id,
                'quantity' => $item->quantity,
                'type' => 'DELETE',
            ]);
        });
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function getItemNameAttribute()
    {
        return $this->item->name;
    }
}
