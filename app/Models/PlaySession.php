<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaySession extends Model
{

    public $timestamps = false;
    protected $guarded = [];
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
