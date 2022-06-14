<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class playSession extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;

    public $timestamps = false;
    protected $guarded = [];
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
