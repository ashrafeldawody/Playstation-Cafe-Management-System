<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];
    protected $hidden = ['inventory','created_at', 'updated_at'];
    protected $appends = ['quantity'];
    public function category()
    {
        return $this->belongsTo(ItemsCategory::class,'items_category_id')->select('id','name');
    }
    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'item_id', 'id');
    }
    public function getQuantityAttribute()
    {
        return $this->inventory->pluck('quantity')->sum();
    }
}
