<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    protected $guarded = [];
    protected $hidden = ['inventory','created_at', 'updated_at'];
    protected $appends = ['quantity'];
    public function itemsCategory()
    {
        return $this->belongsTo(ItemsCategory::class)->select('id','name');
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
