<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];
    protected $hidden = ['inventory','created_at', 'updated_at'];
    protected $appends = ['quantity','revenue'];
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
    public function getRevenueAttribute()
    {
        return $this->price - $this->buy_price;
    }
    public static function top5($start_time=null,$end_time=null){
        $top5 = CafeBillItem::with('item')->selectRaw('cafe_bill_items.item_id, sum(cafe_bill_items.quantity) as total')
            ->join('bills', 'bills.id', '=', 'cafe_bill_items.bill_id')
            ->groupBy('cafe_bill_items.item_id')
            ->orderBy('total', 'desc')
            ->limit(5);

        if($start_time && $end_time){
            $top5->whereBetween('bills.created_at', [$start_time, $end_time]);
        }
        return $top5->get();
    }
}
