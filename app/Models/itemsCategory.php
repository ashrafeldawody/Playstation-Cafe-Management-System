<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class itemsCategory extends Model
{

    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];
    public function items()
    {
        return $this->hasMany(Item::class, 'items_category_id', 'id');
    }
}
