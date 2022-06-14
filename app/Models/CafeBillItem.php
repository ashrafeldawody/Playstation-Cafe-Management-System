<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CafeBillItem extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    protected $guarded = [];

    public function cafeBill()
    {
        return $this->belongsTo(CafeBill::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function ($item) {
            Inventory::create([
                'item_id' => $item->item_id,
                'quantity' => -$item->quantity,
                'type' => 'SELL',
                'user_id' => $item->cafeBill->user_id,
            ]);
        });
        static::deleted(function ($item) {
            Inventory::create([
                'item_id' => $item->item_id,
                'quantity' => $item->quantity,
                'type' => 'RETURN',
                'user_id' => $item->cafeBill->user_id,
            ]);
        });
    }

}
